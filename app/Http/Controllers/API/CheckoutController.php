<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaymentOption;
use App\Models\Payment;
use App\Models\Currency;
use App\Models\Wallet;
use App\Models\SingletonVendor;

class CheckoutController extends BaseController
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
                $order->vendor_id = $request->vendor_id;
                $order->currency_id = $request->currency_id;
                $order->total_amount = $request->total_amount;
                $order->sub_total_amount = $request->sub_total_amount;
                $order->delivery_fee = $request->delivery_fee;
                $order->note = $request->note;
                $order->time_slot = $request->time_slot;
                //
                if( $paymentOption->type == "cash" || $paymentOption->type == "bonifico" ){
                    $order->payment_status = "pending";
                }

                $order->save();


                //crate the record of the ordered products
                foreach( $request->products as $product ){
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $product['id'];
                    $orderProduct->price = $product['price'];
                    $orderProduct->quantity = $product['quantity'];
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
                    $this->sendNewOrderNotifications($order);
                }

                //record earning for vendor
              //  $order->updateVendorEarning(true);

                DB::commit();

                return response()->json([
                    "order" => $order,
                    "transaction_ref" => $transactionRef,
                    "message" => $message,
                    "link" => $link ?? "",
                ], 200);

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
            'success_url' => route('orders.update')."?code=".$order->code."&type=stripe",
            'cancel_url' => route('orders.update')."?code=".$order->code."&type=stripe&status=failed",
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
