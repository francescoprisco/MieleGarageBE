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
            'id' => 'required',
            'personal_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $ebikesUser = EBikeUser::where("id",$request->id)->first();
        $ebikesUser->personal_name = $request->personal_name;
        $ebikesUser->save();
        return $this->success($ebikesUser);
    }

}
