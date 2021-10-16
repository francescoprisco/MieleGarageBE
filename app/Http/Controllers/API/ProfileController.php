<?php

namespace App\Http\Controllers\API;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Provincia;
use Carbon\Carbon;
use Log;
class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();
        return $this->success($profiles);
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
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'provincia_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'user_id' => 'required|unique:profiles'
        ]);

        if($validator->fails()){
            $this->addError(["message"=>"Creazione profilo fallita"]);
            return $this->error();
        }

        $profile = Profile::create($request->all());

        if($request->hasFile('photo')){
            $profile->addMediaFromRequest('photo')->toMediaCollection('users_avatar','users_avatar');
        }
        return $this->success($profile);
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
