<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SparePart;
use App\Models\EBike;
use Illuminate\Support\Facades\Validator;
use Log;

class SparePartController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkprofile');
        $this->middleware('role:admin', ['only' => ['show','create','destroy','edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spare_parts = SparePart::All();
        return view('spareparts.index')->with("spare_parts",$spare_parts);
    }

    public function show($id)
    {
        $spare_part = SparePart::find($id);
        return view('spareparts.show')->with("spare_part",$spare_part);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $e_bikes = EBike::all();
        return view('spareparts.create',compact('e_bikes'));
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
            'code' => 'required|unique:spare_parts',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'description' => 'required',
            'e_bikes' => 'required|array',
            'photo' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('spareparts.index')->with('error','Componente non inserito');
        }

        $sparePart = SparePart::create($request->all());
        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $sparePart->clearMediaCollection('spare_parts_photo');
            $sparePart->addMediaFromRequest('photo')->toMediaCollection('spare_parts_photo','spare_parts_photo');
        }
        $sparePart->e_bikes()->sync($request->e_bikes);
        return redirect()->route('spareparts.index')->with('success','Componente aggiunto con successo');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spare_part = SparePart::find($id);

        $e_bikes = EBike::all();

        return view('spareparts.edit',compact('spare_part','e_bikes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sparePart = SparePart::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'description' => 'required',
            'e_bikes' => 'required|array',
            ]);

        if($validator->fails()){
            return redirect()->route('spareparts.index')->with('error','Componente non aggiornato');
        }

        $sparePart->update($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $sparePart->clearMediaCollection('spare_parts_photo');
            $sparePart->addMediaFromRequest('photo')->toMediaCollection('spare_parts_photo','spare_parts_photo');
        }

        $sparePart->e_bikes()->sync($request->e_bikes);

        return redirect()->route('spareparts.index')->with('success','Componente aggiornato con successo');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sparePart = SparePart::find($id);
        $sparePart->clearMediaCollection('spare_parts_photo');
        $sparePart->delete();
        return redirect()->route('spareparts.index')->with('success','Componente di ricambio cancellato con successo');
    }
}
