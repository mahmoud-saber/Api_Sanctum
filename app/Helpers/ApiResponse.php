<?php

namespace App\Helpers;

class ApiResponse
{
static function SendResponse($code = 200 ,$message = null , $data = null){
     $response = [
        'status'=>$code,
        'message'=>$message,
        'data'=>$data
    ];
    return response()->json($response,$code);
}
}