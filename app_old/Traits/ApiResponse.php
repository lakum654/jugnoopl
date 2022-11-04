<?php

namespace App\Traits;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait ApiResponse
{
    public function  setResponse($status, $data, $code,$type='l')
    {
        if (in_array($code, array(200))) {
            $para = ($type=='l')?'data':'message';
            return response(json_encode(
                [
                    'status'        =>  $status, // true or false
                    'code'          =>  $code,
                     $para          =>  $data
                ]
            ), $code)->header('Content-Type', 'application/json');
        } else {
            return response(json_encode(
                [
                    'status'        =>  $status, // true or false
                    'code'          =>  $code,
                    'message'       =>  $data
                ]
            ), $code)->header('Content-Type', 'application/json');
        }
    }
}
