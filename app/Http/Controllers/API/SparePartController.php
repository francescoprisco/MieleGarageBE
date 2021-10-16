<?php

namespace App\Http\Controllers\API;

use App\Models\SparePart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($sparePart_id)
    {
        $sparePart = SparePart::find($sparePart_id);

        return $this->success($sparePart);
    }
}
