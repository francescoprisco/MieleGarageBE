<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderSparePart;
use App\Models\PaymentOption;
use App\Models\Payment;

class CheckoutController extends Controller
{
    //
    public function initiate(CheckoutRequest $request)
    {
            try{
                DB::beginTransaction();

                $paymentOption = PaymentOption::findOrfail($request->payment_option_id);
                $order = new Order();
                $order->user_id = Auth::id();
                $order->code = strtoupper(Str::random(10));
                $order->payment_option_id = $request->payment_option_id;
                $order->delivery_address_id = $request->delivery_address_id;
                $order->total_amount = $request->total_amount;
                $order->sub_total_amount = $request->sub_total_amount;
                $order->delivery_fee = $request->delivery_fee;

                if( $paymentOption->type == "cash" || $paymentOption->slug == "transfer" ){
                    $order->payment_status = "pending";
                }
                if( $paymentOption->type == "cash" || $paymentOption->slug == "cash" ){
                    $order->payment_status = "pending";
                }

                $order->save();


                //crate the record of the ordered products
                foreach( $request->spare_parts as $sparepart ){
                    $orderProduct = new OrderSparePart();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->spare_part_id = $sparepart['id'];
                    $orderProduct->price = $sparepart['price'];
                    $orderProduct->quantity = $sparepart['quantity'];
                    $orderProduct->save();
                }

                $message = "Ordine inserito con successo!. ";
                if( $paymentOption->type != "cash"){
                    $message .= "Please follow the prompt to complete payment. Thank you";
                }

                //
                $transactionRef = "";

                if ( $paymentOption->type == "card" && $paymentOption->slug == "stripe" ){

                    $paymentTransaction = $this->stripePayCheckOut($paymentOption, $order);
                    $link = route('payment.initiate',["code" => $order->code, "payment_option_id" => $paymentOption->id, "data" => $paymentTransaction->id ]);
                    //save the payment
                    $payment = new Payment();
                    $payment->order_id = $order->id;
                    $payment->payment_option_id = $paymentOption->id;
                    $payment->transaction_ref = $paymentTransaction->payment_intent;
                    $payment->save();
                }

                if( $paymentOption->type == "cash" ){
                    //send notification and mail
                    //$this->sendNewOrderNotifications($order);
                }

                DB::commit();
                return $this->success([
                    "order" => $order,
                    "transaction_ref" => $transactionRef,
                    "message" => $message,
                    "link" => $link ?? "",
                ]);

            }catch(\Exception $error){

                Log::error(
                    [
                        "Error" => $error->getMessage(),
                        "Line" => $error->getLine(),
                        "File" => $error->getFile(),
                    ]
                );

                DB::rollBack();
                return response()->json([
                    "message" => $error->getMessage(),
                    "Line" => $error->getLine(),
                    "File" => $error->getFile(),
                ], 500);

            }
    }


    //Stripe
    protected function stripePayCheckOut($paymentOption,$order){

        $stripe = new \Stripe\StripeClient($paymentOption->secret_key);
        // Create a Checkout Session
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => route('payment.update')."?code=".$order->code."&type=stripe",
            'cancel_url' => route('payment.update')."?code=".$order->code."&type=stripe&status=failed",
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Order Checkout',
                        ],
                        'unit_amount' => $order->total_amount * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
        ]);

        Log::info(["Stripe Data" => $checkout]);

        return $checkout;

    }

}
