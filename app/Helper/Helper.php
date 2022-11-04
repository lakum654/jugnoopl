<?php

use App\Models\EmployeeCommission;
use App\Models\Outlet;
use App\Models\TransferHistory;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

if (!function_exists('uniqCode')) {
    function uniqCode($lenght)
    {
        // uniqCode
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return strtoupper(substr(bin2hex($bytes), 0, $lenght));
    }
}


if (!function_exists('singleFile')) {

    function singleFile($file, $folder)
    {
        if ($file) {
            if (!file_exists($folder))
                mkdir($folder, 0777, true);

            $filename = date('YmdHis') . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/' . $folder, $filename);
            return $filename;
        }
        return false;
    }
}

if (!function_exists('imgPath')) {

    function imgPath($folder, $file)
    {
        if (!$file)
            return asset('no-img.png');

        return asset($folder . '/' . $file);
    }
}

if (!function_exists('multipleFile')) {

    function multipleFile($files, $folder)
    {

        $fileNames = [];
        foreach ($files as $key => $file) {
            if ($file) {
                if (!file_exists($folder))
                    mkdir($folder, 0777, true);

                $filename = date('YmdHis') . rand(11111, 99999) . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/' . $folder, $filename);
                $fileNames[$key] =  $filename;
            }
        }

        return $fileNames;
    }
}


if (!function_exists('pr')) {
    function pr($data, $flag = false)
    {
        echo "<pre>";
        print_r($data);
        echo '</pre>';
        if ($flag)
            die;
    }
}


if (!function_exists('profileImg')) {

    function profileImg()
    {
        return (!empty(auth()->user()->profile_img)) ? asset('users') . '/' . auth()->user()->profile_img :asset('assets/images/faces/face1.jpg');
    }
}


if (!function_exists('role')) {

    function role()
    {
        return Auth::user()->role;
    }
}
