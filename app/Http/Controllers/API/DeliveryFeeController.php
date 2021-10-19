<?php

namespace App\Http\Controllers\API;

use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DeliveryFeeController extends Controller
{
    public function index()
    {
        $deliveryFees = DeliveryFee::orderBy("min_weight")->get();
        return $this->success($deliveryFees);
    }
}
