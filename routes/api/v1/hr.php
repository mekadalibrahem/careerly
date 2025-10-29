<?php

use App\Http\Controllers\Api\Works\WorkController;
use App\Http\Controllers\Api\Works\WorkRequirmentController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",
    "middleware" => [],
], function () {
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::apiResource("works", WorkController::class);
        Route::apiResource("works/{work}/workRequirments", WorkRequirmentController::class);
    });
});
