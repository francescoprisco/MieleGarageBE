<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EBikeUser;
use Illuminate\Http\Request;
use App\Models\EBike;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class EBikeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $ebikes = $user->e_bikes()->wherePivot('user_id', '=', $user->id)->withPivot('personal_name')->withPivot('frame_number')->withPivot('blue_id')->withPivot('id')->get();

        return $this->success($ebikes);
    }

    public function show($id)
    {
        $user = Auth::user();
        $ebike = $user->e_bikes()->wherePivot('user_id', '=', $user->id)->wherePivot('id', '=', $id)->withPivot('personal_name')->withPivot('frame_number')->withPivot('blue_id')->withPivot('id')->first();

        if($ebike)
        {
            return $this->success($ebike);
        }else{
            $this->addError(["message"=>"Bici non trovata"]);
            return $this->error();
        }
    }

    public function connectEBikeToUserFromWP(Request $request)
    {
        $header = $request->header('User-Agent');
        if(strpos($header, "WordPress") !== false && strpos($header, "MieleConnect") !== false)
        {
        }else{
            return response()->json("Richiesta non valida", 400);
        }
        $validator = Validator::make($request->all(),[
            'product_skus' => 'required',
            'user' => 'required',
            'order_number' => 'required',
            'wp_token' => 'required|in:'.env("WP_TOKEN"),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $skus = $request["product_skus"];
        $wp_user = $request["user"];
        $ebike_array = array();
        foreach ($skus as $sku)
        {
            $ebike = EBike::where("sku",$sku)->first();
            array_push($ebike_array,$ebike->id);
        }
        $user = User::where("username",$wp_user["data"]["user_login"])->first();
        $user->e_bikes()->sync($ebike_array);
    }
}
