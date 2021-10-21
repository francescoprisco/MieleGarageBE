<?php

namespace App\Http\Controllers\API;

use App\Models\EBike;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EBikeUser;
use Illuminate\Support\Facades\Auth;

class EBikeConnectorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeName(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'e_bike_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $ebikesUser = EBikeUser::where("e_bike_id",$request->e_bike_id)->where("user_id",Auth::id())->first();
        $ebikesUser->name = $request->name;
        $ebikesUser->save();
        return $this->success($ebikesUser);
    }

}
