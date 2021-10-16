<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($ebike_id)
    {
        $categories = Category::whereHas('spare_parts', function($q) use($ebike_id){
            $q->whereHas('e_bikes', function($q) use($ebike_id){
                $q->where('e_bikes.id', '=', $ebike_id);
            });
        })->get();
        return $this->success($categories);
    }
}
