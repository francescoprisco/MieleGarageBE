<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FirebaseAuthTrait;
use App\Traits\NotificationTrait;

class OrderController extends Controller
{

    use FirebaseAuthTrait, NotificationTrait;

    public function index(Request $request)
    {
        //check if the user requesting this is a driver user
        if (Auth::user()->hasRole('driver')) {

            $type = $request->type;
            $orders = Order::with('currency', 'vendor', 'products.product', 'deliveryAddress', 'paymentOption', 'user')
                ->where('driver_id', Auth::id())
                ->when(!empty($type), function ($query) {
                    return $query->whereIn('status', ['delivered', 'failed']);
                }, function ($query) {
                    return $query->whereNotIn('status', ['delivered', 'failed']);
                })
                ->orderBy("updated_at", 'desc')
                ->paginate(config('constants.paginate'));
            //Log::debug(['Orders' => $orders]);

        } else {

            $type = $request->type;
            $status = $request->status;
            $orders = Order::with('currency', 'vendor', 'products.product', 'deliveryAddress', 'paymentOption', 'driver')
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->when($type == "vendor", function ($query) use ($type) {
                    return $query->where('vendor_id', Auth::user()->vendor_id)->with('user');
                }, function ($query) {
                    return $query->where('user_id', Auth::id());
                })
                ->orderBy("updated_at", 'desc')
                ->paginate(config('constants.paginate'));
        }
        return response()->json($orders, 200);
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
