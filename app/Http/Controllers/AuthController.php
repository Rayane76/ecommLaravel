<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            "name" => ["required","string"],
            "email" => ["required","email","unique:users"],
            "password" => ["required","string","min:5"],
        ]);

        $user = User::create($data);

        $token = $user->createToken("auth_token")->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];

    }

    
    public function login(Request $request){
        $data = $request->validate([
            "email" => ["required","email","exists:users"],
            "password" => ["required","string","min:5"],
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response([
                'message' => 'wrong credentials'
            ], 401);
        }
        

        $token = $user->createToken("auth_token")->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
        
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return response()->json("you have successfully been logged out");
    }


}
