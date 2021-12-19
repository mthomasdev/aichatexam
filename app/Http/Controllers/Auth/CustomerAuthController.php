<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    public function customerLogin(Request $request)
    {
        $credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (auth()->attempt($credentials)) {
            $user_login_token= auth()->user()->createToken('AiChatToken')->accessToken;
       

            return response()->json(['token' => $user_login_token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    public function me()
    {
        return response()->json(['me' => auth()->user()], 200);
    }
}
