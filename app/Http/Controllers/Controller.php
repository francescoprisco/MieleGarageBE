<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $errors = array();
    public function error($data = [""],$code=400)
    {
        $payload = array();
        $payload["errors"] = $this->errors;
        $payload["data"] = $data;
        return response()->json($payload, $code);
    }

    public function success($data = [""],$code=200)
    {
        $payload = array();
        $payload["errors"] = [];
        $payload["data"] = $data;
        return response()->json($payload, $code);
    }

    public function addError($error)
    {
        array_push($this->errors,$error);
    }
}
