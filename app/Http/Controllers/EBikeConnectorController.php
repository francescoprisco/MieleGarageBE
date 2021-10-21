<?php

namespace App\Http\Controllers;

use App\Models\EBike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EBikeUser;

class EBikeConnectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('role:admin');
        /* $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);*/
        // $this->middleware('role:admin', ['only' => ['show','create','destroy','edit']]);
        $this->middleware('checkprofile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ebikesUser = EBikeUser::all();
        return view('ebikes.connector.index',compact('ebikesUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $e_bikes = EBike::all();
        return view('ebikes.connector.create')->with('users',$users)->with("e_bikes",$e_bikes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'e_bike_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('ebikesconnector.index')->with('error','Bici e utente non collegati');
        }

        EBikeUser::create($request->all());

        return redirect()->route('ebikesconnector.index')->with('success','Bici collegata all\'utente con successo.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EBikeUser = EBikeUser::find($id);
        $EBikeUser->delete();
        return redirect()->route('ebikesconnector.index')->with('success','Bici scollegata con successo');
    }
}
