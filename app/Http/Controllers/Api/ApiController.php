<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiController extends Controller
{
    public function register(Request $request){

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
            "user_type" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }

    // Login API (POST, formdataessToken;
}
