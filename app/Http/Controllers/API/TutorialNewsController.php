<?php

namespace App\Http\Controllers\API;
use App\Models\TutorialNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorialNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tutorials()
    {
        $tutorials = TutorialNews::where("type","0");
        return $this->success($tutorials);
    }

    public function news()
    {
        $tutorials = TutorialNews::where("type","1");
        return $this->success($tutorials);
    }
    public function showTutorialsNews($id)
    {
      print_r($id);
    }
}
