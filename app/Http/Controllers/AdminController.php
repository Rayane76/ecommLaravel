<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    
    public function login(Request $request){
        $data = $request->validate([
            "username" => ["required","string","exists:admins"],
            "password" => ["required","string","min:5"],
        ]);

        $admin = Admin::where('username', $data['username'])->first();

        if(!$admin || !Hash::check($data['password'], $admin->password)){
            return response([
                'message' => 'wrong credentials'
            ], 401);
        }
        

        $token = $admin->createToken("auth_token", ["admin"])->plainTextToken;

        return [
            'admin' => $admin,
            'token' => $token
        ];
        
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return response()->json("you have successfully been logged out");
    }

}
