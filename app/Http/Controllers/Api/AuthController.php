<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)

    {
        try {

            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->setResponse(false, 'Login credentials are invalid.', 403);
            }
            //Token created, return with success response and jwt token
            return $this->createNewToken($token);
        } catch (JWTException $e) {
            return $this->setResponse(false, 'Could not create token.', 500);
        }
    }

    protected function createNewToken($token)
    {
        return $this->setResponse(true, [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'data' => Auth::user()
        ], 200);
    }
}
