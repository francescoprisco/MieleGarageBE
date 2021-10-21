<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use App\Models\SparePart;
use App\Models\EBike;
use Illuminate\Support\Facades\Validator;
use Log;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkprofile');
        // $this->middleware('role:admin', ['only' => ['show','create','destroy','edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDeliveryFees()
    {
        $deliveryFees = DeliveryFee::orderBy("min_weight")->get();
        return view('settings.deliveryfees.index')->with("deliveryFees",$deliveryFees);
    }

    public function createDeliveryFees()
    {
        return view('settings.deliveryfees.create');
    }

    public function storeDeliveryFees(Request $request)
    {
        $deliveryFee = DeliveryFee::where("min_weight",$request->min_weight)->get();
        if(count($deliveryFee)>0)
        {
            return redirect()->route('deliveryfees.index')->with('error','Già esiste un costo di spedizione per il peso inserito.');
        }else{
            DeliveryFee::create($request->all());
            return redirect()->route('deliveryfees.index')->with('success','Costo di spedizione aggiunto con successo.');
        }
    }

    public function deleteDeliveryFees(Request $request,$id)
    {
            $deliveryFee = DeliveryFee::find($id);
            $deliveryFee->delete();
            return redirect()->route('deliveryfees.index')->with('success','Costo di spedizione eliminato con successo.');
    }
}
