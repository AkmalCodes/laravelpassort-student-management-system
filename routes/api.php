<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
],function(){
    Route::get("profile", [UserController::class, "profile"]);
    Route::get("logout", [UserController::class, "logout"]);
    Route::post("search_students_email", [StudentController::class, "search_students_email"]);
    Route::post("search_students_name", [StudentController::class, "search_students_name"]);
});
