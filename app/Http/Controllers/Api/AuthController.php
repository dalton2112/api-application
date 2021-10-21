<?php

namespace App\Http\Controllers\Api;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return response()->json([
                'msg' => 'Credentials not match',
            ], 401);
        }

        return response()->json([
            'msg' => 'Login Success!',
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ], 201);
    }
    
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'msg' => 'Logout Success!',
        ];
    }

    public function me()
    {
        return auth()->user();
    }
}
