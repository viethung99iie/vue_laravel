<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function __construct() {

    }

     public function login(AuthRequest $request){
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $token = $request->user()->createToken('backend_token', ['*'], now()->addMinutes(60));
            $user = $request->user();

            return response()
            ->json([
                'token' => $token->plainTextToken,
                'token_exprires_at' => $token->accessToken->expires_at,
                'user' => $user
            ], ResponseEnum::OK);
        }

        return response()->json([
            'message' => 'Tài khoản hoặc mật khẩu không chính xác'
        ], ResponseEnum::UNAUTHORIZED);
    }

}
