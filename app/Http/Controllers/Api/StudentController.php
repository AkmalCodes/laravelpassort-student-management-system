<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
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
            ->paginate(10);
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
