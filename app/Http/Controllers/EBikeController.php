<?php

namespace App\Http\Controllers;

use App\Models\EBike;
use Illuminate\Http\Request;
class EBikeController extends Controller
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
        $ebikes = EBike::all();
        return view('ebikes.index',compact('ebikes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ebikes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required',
            'name' => 'required',
            'description' => 'required',
            'wheels_size' => 'required',
            'battery' => 'required',
            'power' => 'required',
            'photo' => 'required|file',
        ]);

        $ebike = EBike::create($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $ebike->addMediaFromRequest('photo')->toMediaCollection('bikes_photo','bikes_photo');
        }
        return redirect()->route('ebikes.index')->with('success','Bici aggiunta con successo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function show(EBike $ebike)
    {
        return view('ebikes.show',compact('ebike'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function edit(EBike $ebike)
    {
        return view('ebikes.edit',compact('ebike'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EBike $ebike)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            'name' => 'required',
            'description' => 'required',
            'wheels_size' => 'required',
            'battery' => 'required',
            'power' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('ebikes.index')->with('error','Bici non aggiornata');
        }

        $ebike->update($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $ebike->clearMediaCollection('bikes_photo');
            $ebike->addMediaFromRequest('photo')->toMediaCollection('bikes_photo','bikes_photo');
        }

        return redirect()->route('ebikes.index')->with('success','Bici aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function destroy(EBike $ebike)
    {
        $ebike->clearMediaCollection('bikes_photo');
        $ebike->delete();
        return redirect()->route('ebikes.index')->with('success','Bici cancellata con successo');
    }
}
