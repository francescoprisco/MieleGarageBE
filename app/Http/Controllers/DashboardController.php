<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EBike;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users_num = count(User::all());
        $ebikes_num = count(EBike::all());
        $title = "Dashboard";
        return view('home')->with("users_num",$users_num)->with("ebikes_num",$ebikes_num);
    }
}
