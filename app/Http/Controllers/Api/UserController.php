<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;


class UserController extends Controller
{
    public function register(Request $request)
    {
        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:user",
            "user_type" => "required|in:Student,Lecturer",
            "password" => "required|confirmed"
        ]);

        // Author model
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "user_type" => $request->user_type,
            "password" => Hash::make($request->password)
        ]);

        if ($user->user_type === 'Student') {
            // Create the student record using the user's ID
            Student::create([
                "student_name" => $user->name,
                "student_email" => $user->email,
                "user_id" => $user->id // Use the created user's ID
            ]);
        }else if ($user->user_type === 'Lecturer') {
            // Create the student record using the user's ID
            Student::create([
                "lecturer_name" => $user->name,
                "lecturer_email" => $user->email,
                "user_id" => $user->id // Use the created user's ID
            ]);
        }

        // Response
        return response()->json([
            "user_id" => $user->id,
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
