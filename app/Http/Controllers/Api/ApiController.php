<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "user_type" => "required|in:Student,Lecturer",
            "password" => "required|confirmed"
        ]);

        // Author model
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "user_type" => $request->user_type,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        //check login credentials
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            $user = Auth::user(); // creates user object for reference if needed
            $token = $user->createToken("myToken")->accessToken;
            return response()->json([
                "status" => True,
                "message" => "Login Successful",
                "token" => $token,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        };
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json([
            "status" => true,
            "message" => "User Logged Out",
        ]);
    }

}
