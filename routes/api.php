<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PasswordUpdateController;
use App\Http\Controllers\ProfileUpdateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[AuthController::class,'register']);

Route::post('login',[AuthController::class,'login']);


//Route::middleware('auth:api')->get('/profile', [AuthController::class, 'profile']);



Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('reset-password', [PasswordResetController::class, 'resetPassword']);



Route::middleware('auth:api')->group(function () {
    Route::get('profile', [AuthController::class,'profile']);
    Route::put('/profileUpdate', [ProfileUpdateController::class, 'update']);
    Route::post('logout',[AuthController::class,'logout']);
});


