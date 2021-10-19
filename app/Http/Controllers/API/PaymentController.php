<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentOption;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use App\Models\SingletonVendor;


class PaymentController extends Controller
{

    public function stripeUpdate(Request $request){

        $failed = false;
        $message = "An error occurred. Please try again later";

        try{

            $requestContent = json_decode($request->getContent());
            $paymentIntent = $requestContent->data->object->payment_intent;
            $payment = Payment::where('transaction_ref', $paymentIntent)->first();
            $paymentOption = PaymentOption::find($payment->payment_option_id);
            $order = Order::find($payment->order_id);
            $verified = $this->verifyStripeTransaction($paymentOption, $order, $request);
            Log::info($verified);
            if($verified===true){
                //update payment

                $payment->status = "successful";
                $payment->save();

                //update order status
                $order->status = "preparing";
                $order->payment_status = "successful";
                $order->save();

                //setting the failed status data
                $failed = false;
                $message = "Pagamento completato. A breve lo stato dell'ordine sarà aggiornato. Clicca sulla freccia in alto a sinistra per uscire dalla procedura di pagamento.";

                //send notification and mail
                $this->sendNewOrderNotifications($order);
            }else if($verified===false){
                //update payment
                $payment->status = "failed";
                $payment->save();

                //update order status
                $order->status = "cancelled";
                $order->payment_status = "failed";
                $order->save();
                //setting the failed status data
                $failed = true;
                $message = "Pagamento Fallito.Riprova o contatta l'assistenza per conoscerne i motivi";
            }

        }catch(\Exception $ex){

            Log::error(
                [
                    "message" => $ex->getMessage(),
                    "file" => $ex->getFile(),
                    "linne" => $ex->getLine(),
                ]
            );

            $failed = true;
            $message = $ex->getMessage() ?? $message;

        }

        return response()->json([
            "message" => $message,
        ], $failed ? 500 : 200);

    }


    //normal successful or failded page
    // the actually payment verification would be done at the webhook part
    public function update(Request $request){

        // check the type
        $failed = true;
        $message = "An error occurred. Please try again later";
        try{
            $order = Order::where('code', $request->reference ?? $request->code)->first();
            $paymentOption = PaymentOption::find($order->payment_option_id);
            $verified = $this->verifyStripeTransaction($paymentOption, $order, $request);

            // handle stripe
            if( $paymentOption->type == "card" && $paymentOption->slug == "stripe" ){
                if(empty($request->status)){
                    //setting the failed status data
                    $failed = false;
                    $message = "Pagamento completato. A breve lo stato dell'ordine sarà aggiornato. Clicca sulla freccia in alto a sinistra per uscire dalla procedura di pagamento.";
                }else if($verified && $request->status == "failed"){
                    //setting the failed status data
                    $failed = true;
                    $message = "Pagamento Fallito.Riprova o contatta l'assistenza per conoscerne i motivi";
                }
            }
            return view('layouts.paymentalert', compact('failed','message'));
        }catch(\Exception $ex){
            $failed = true;
            $message = $ex->getMessage() ?? $message;
            return view('layouts.paymentalert', compact('failed','message'));
        }

    }

    //Stripe verification
    protected function verifyStripeTransaction($paymentOption,$order,$request){

        $payment = Payment::where('order_id',$order->id)->first();

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey($paymentOption->secret_key);

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $paymentOption->secret_hash;

        $payload = $request->getContent();
        $signature = $request->header('stripe-signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $signature, $endpoint_secret
            );
            Log::info($event);
            if (strpos($event->type, 'fail') !== false) {
                return false;
            }else{
                return true;
            }
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            // http_response_code(400); // PHP 5.4 or greater
            return false;

        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            // http_response_code(400); // PHP 5.4 or greater
            return false;
        }

        // Do something with $event
        // http_response_code(200); // PHP 5.4 or greater
        return true;
    }


}
