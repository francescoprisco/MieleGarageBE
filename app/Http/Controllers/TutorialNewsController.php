<?php

namespace App\Http\Controllers;

use App\Models\TutorialNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TutorialNewsController extends Controller
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
        // $this->middleware('checkprofile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutorialNews = TutorialNews::all();
        return view('tutorialnews.index',compact('tutorialNews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tutorialnews.create');
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
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'photo' => 'required|file',
            'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);

        if($validator->fails()){
            return redirect()->route('tutorialnews.index')->with('error','Tutorial/News non creato');
        }

        $tutorialNews = TutorialNews::create($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $tutorialNews->addMediaFromRequest('photo')->toMediaCollection('newstutorial_photo','newstutorial_photo');
        }
        if($request->hasFile('video') && $request->file('video')->isValid()){
            $tutorialNews->addMediaFromRequest('video')->toMediaCollection('newstutorial_video','newstutorial_video');
        }
        return redirect()->route('tutorialnews.index')->with('success','Tutorial/News aggiunto con successo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function show(TutorialNews $tutorialNews)
    {
        return view('tutorialnews.show',compact('tutorialNews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutorialNews = TutorialNews::find($id);
        return view('tutorialnews.edit',compact('tutorialNews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tutorialNews = TutorialNews::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'photo' => 'required|file',
            'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);

        if($validator->fails()){
            return redirect()->route('tutorialnews.index')->with('error','Tutorial/news non aggiornato');
        }

        $tutorialNews->update($request->all());

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $tutorialNews->clearMediaCollection('newstutorial_photo');
            $tutorialNews->addMediaFromRequest('photo')->toMediaCollection('newstutorial_photo','newstutorial_photo');
        }
        if($request->hasFile('video') && $request->file('video')->isValid()){
            $tutorialNews->clearMediaCollection('newstutorial_video');
            $tutorialNews->addMediaFromRequest('video')->toMediaCollection('newstutorial_video','newstutorial_video');
        }
        return redirect()->route('tutorialnews.index')->with('success','Tutorial/News aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EBike  $ebike
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutorialNews = TutorialNews::find($id);
        $tutorialNews->clearMediaCollection('newstutorial_photo');
        $tutorialNews->clearMediaCollection('newstutorial_video');
        $tutorialNews->delete();
        return redirect()->route('tutorialnews.index')->with('success','Tutorial/news cancellato con successo');
    }
}
