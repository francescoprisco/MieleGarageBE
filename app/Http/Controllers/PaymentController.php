<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentOption;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    //
    public function initiate(Request $request,$code,$paymentOptionId,$data = ""){

        $order = Order::where('code',$code)->first();
        $paymentOption = PaymentOption::where('id',$paymentOptionId)->first();
        return view('payment.initiate', compact( 'order', 'paymentOption', 'data'));

    }

}
