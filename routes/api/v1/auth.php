<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::group([
    "prefix" => "v1",
    "middleware" => [],
], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::get('/logout' , [AuthController::class,'logout'])->name("user.logout")->middleware('auth:sanctum');
});
