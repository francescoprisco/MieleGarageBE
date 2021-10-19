<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Traits\FirebaseAuthTrait;
//use App\Traits\NotificationTrait;
use Log;
class OrderController extends Controller
{

    //use NotificationTrait;

    public function index(Request $request)
    {
        //check if the user requesting this is a driver user
            $orders = Order::with('spare_parts.spare_part', 'deliveryAddress', 'paymentOption', 'user')->where('user_id', Auth::id())->orderBy("updated_at", 'desc')->get();

        //Log::debug(['Orders' => $orders]);
       // return response()->json($orders, 200);

        return $this->success($orders);
    }


    public function update(Request $request, $id)
    {

        $order = Order::with('spare_parts', 'deliveryAddress', 'paymentOption', 'user')->findOrfail($id);

        //check if the user requesting this is a driver user
        if (Auth::check()) {

            $order->status = $request->status;
            $order->save();
            return response()->json(["message" => "Order Updated"], 200);

            if ($request->status) {
                $order->status = $request->status;
            }
            $order->driver_id = $request->driver_id;
            $order->save();

            //send notification to the right parties
            //$this->notifyAboutOrderStatus($order);


            return response()->json([
                "message" => "Order Updated",
                "order" => $order,
            ], 200);
        } else {
            return response()->json(["message" => "Unautenticated User"], 401);
        }
    }
}
