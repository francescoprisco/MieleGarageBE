<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Provincia;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        /* $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Profile::all();
        return view('users.profiles.index',compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = Provincia::orderBy("name","ASC")->get();
        $cities = array();
        return view('users.profiles.create')->with("province",$province)->with("cities",$cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(["user_id"=>Auth::id()]);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'provincia_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'photo' => 'required|file',
            'user_id' => 'required|unique:profiles'
        ]);

        if($validator->fails()){
            return redirect()->route('profiles.create')->with('error','Profilo non creato');
        }


        $profile = Profile::create($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $profile->addMediaFromRequest('photo')->toMediaCollection('users_avatar','users_avatar');
        }

        return redirect()->route('dashboard')->with('success','Profilo aggiunto con successo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return view('users.profiles.show',compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profiles.edit',compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'provincia_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'photo' => 'required|file',
        ]);

        if($validator->fails()){
            return redirect()->route('profiles.index')->with('error','Profilo non aggiornato');
        }

        $profile->update($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $profile->clearMediaCollection('users_avatar');
            $profile->addMediaFromRequest('photo')->toMediaCollection('users_avatar','users_avatar');
        }

        return redirect()->route('profiles.index')->with('success','Profilo aggiornato con successo');
    }
}
