<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;

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

    public function search_students_email(Request $request)
    {
        // Authenticate that the current user is logged in and is a Lecturer
        if (!Auth::check() || Auth::user()->user_type !== 'Lecturer') {
            return response()->json([
                "status" => false,
                "message" => "Unauthorized access"
            ], 403); // 403 Forbidden response
        }

        // Validate the search input
        $request->validate([
            "search" => "required", // assuming search can be name or email
        ]);

        // Attempt to find students by name or email
        $students = Student::where(function ($query) use ($request) {
                $query->where('student_email', 'LIKE', $request->search . '%');
            })
            ->paginate(10);;

        if ($students->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No students found"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Students found",
            "students" => $students
        ]);
    }


    public function search_students_name(Request $request)
    {
        // Authenticate that the current user is logged in and is a Lecturer
        if (!Auth::check() || Auth::user()->user_type !== 'Lecturer') {
            return response()->json([
                "status" => false,
                "message" => "Unauthorized access"
            ], 403); // 403 Forbidden response
        }

        // Validate the search input
        $request->validate([
            "search" => "required", // assuming search can be name or email
        ]);

        // Attempt to find students by name or email
        $students = Student::where(function ($query) use ($request) {
            $query->where('student_name', 'LIKE', $request->search . '%');
        })
        ->paginate(10);;

        if ($students->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No students found"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Students found",
            "students" => $students
        ]);
    }
}
