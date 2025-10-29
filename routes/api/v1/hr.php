<?php

use App\Http\Controllers\Api\Works\WorkController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",
    "middleware" => [],
], function () {
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::apiResource("works", WorkController::class);
    });
});
