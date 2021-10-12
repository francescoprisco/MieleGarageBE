<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Provincia;

class PCController extends Controller
{
    public function getCities(Request $request)
    {
        $cities = City::where("provincia_id",$request->provincia_id)->get();
        return $this->success($cities);
    }
    public function getJson(){
        $province = Provincia::all();
        return response()->json($province, 200);
    }
}
