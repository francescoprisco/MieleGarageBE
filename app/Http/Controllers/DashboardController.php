<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EBike;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkprofile');
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
        $current_user = Auth::user();
        return view('dashboard')->with('user',$current_user)->with("users_num",$users_num)->with("ebikes_num",$ebikes_num);
    }
}
