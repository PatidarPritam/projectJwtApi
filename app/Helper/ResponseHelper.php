<?php

namespace App\Helper;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function success($status="success",$message=null,$data=[]){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
            ]);
    }

    public static function errors($status="errors",$message=null){
        return response()->json([
            'status' => $status,
            'message' => $message,
            ]);
    }
}
