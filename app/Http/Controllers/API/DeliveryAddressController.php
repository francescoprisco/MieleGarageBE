<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Http\Requests\DeliveryAddressStoreRequest;
use App\Http\Requests\DeliveryAddressUpdateRequest;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryAddressController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deliveryAddresses = DeliveryAddress::where('user_id',Auth::id())->get();

        return response()->json([
            "data" => $deliveryAddresses,
        ], 200);
    }

    public function default(Request $request){

        try{
            $deliveryAddress = DeliveryAddress::where('user_id', Auth::id())->where('is_default', 1)->first();
            if( empty($deliveryAddress) ){
                $order = Order::where('user_id', Auth::id() )->latest()->first();
                $deliveryAddress = $order->deliveryAddress;
            }
            if( !empty($deliveryAddress) ){
                return $deliveryAddress;
            }else{
                throw new Exception('No Delivery Address found!');
            }

        }catch(Exception $ex){
            return response()->json([
                "message" => 'No Delivery Address found!',
            ], 400);
        }
    }


    /**
     * @param \App\Http\Requests\DeliveryAddressStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryAddressStoreRequest $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $deliveryAddress = DeliveryAddress::create($request->all());
        return response()->json([
            "message" => 'Delivery Address created successfully!',
        ], 200);
    }

    /**
     * @param \App\Http\Requests\DeliveryAddressUpdateRequest $request
     * @param \App\DeliveryAddress $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryAddressUpdateRequest $request, $id)
    {

        $deliveryAddress = DeliveryAddress::findOrfail($id);
        if( $deliveryAddress->user_id != Auth::id() ){
            return response()->json([
                "message" => 'Delivery Address can\'t be updated',
            ], 401);
        }else{
            $deliveryAddress->update($request->all());
            return response()->json([
                "message" => 'Delivery Address updated successfully!',
            ], 200);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeliveryAddress $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $deliveryAddress = DeliveryAddress::findOrfail($id);
        if( $deliveryAddress->user_id != Auth::id() ){
            return response()->json([
                "message" => 'Delivery Address can\'t be deleted',
            ], 401);
        }else{
            $deliveryAddress->delete();
            return response()->json([
                "message" => 'Delivery Address deleted successfully!',
            ], 200);
        }

    }

}
