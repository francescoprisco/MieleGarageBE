<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use LaravelFCM\Facades\FCM;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $orders = Order::orderBy("updated_at",'desc')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $order = Order::with('spare_parts','deliveryAddress')->findOrfail($id);
        return view('orders.show', compact('order'));
    }
    public function edit(Request $request, $id)
    {
        $order = Order::with('spare_parts','deliveryAddress')->findOrfail($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id){
        try{
            $order = Order::findOrfail($id);
            $order->status = $request->status;
            $order->tracking_code = $request->tracking_code;
            $order->save();
            $request->session()->flash('successful', "Order status updated successfully!");
            return redirect()->route('order.show', $order);
        }catch( \Exception $ex ){
            $request->session()->flash('error', $ex->getMessage() ?? "Order status update failed!");
            return redirect()->route('orders.show', $order);
        }
    }
}
