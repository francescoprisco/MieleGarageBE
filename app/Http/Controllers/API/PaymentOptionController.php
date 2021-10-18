<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentOptionStoreRequest;
use App\Http\Requests\PaymentOptionUpdateRequest;
use App\Models\PaymentOption;
use Illuminate\Http\Request;

class PaymentOptionController extends Controller
{
    public function index(Request $request)
    {
        $paymentOptions = PaymentOption::where('is_active',1)->get();
        return response()->json(
            [
                "data" => $paymentOptions,
            ], 200);
    }
}
