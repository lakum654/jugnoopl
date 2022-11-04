<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if (Auth::user()->role == 'admin') {
               return redirect()->intended('admin/dashboard');
            } else if (Auth::user()->role == 'supplier' || Auth::user()->role == 'shopkeeper'  || Auth::user()->user == 'warehouse') {
                return redirect()->intended('user/u-dashboard');
            }
        }
        return redirect("/")->with('error', 'Login Credentails are Invalid');
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
