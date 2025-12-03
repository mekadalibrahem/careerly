<?php

use App\Modules\Admin\Http\Controllers\Api\StatsController;
use App\Modules\Admin\Http\Controllers\Api\UserController;
use App\Modules\Admin\Http\Middleware\HasAdminRoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",

], function () {
    Route::group([
        'middleware' => ['auth:sanctum', HasAdminRoleMiddleware::class],
    ], function () {
        Route::group([
            "prefix" => "admin",
            'as' => 'admin.'
        ], function () {
            Route::group([
                'prefix' => "users",
                "as" => "users."
            ], function () {
                Route::get("", [UserController::class, 'index'])->name("index");
                Route::get("/{user}", [UserController::class, 'show'])->name("show");
                Route::delete("/{user}", [UserController::class, 'delete'])->name("delete");
                Route::post("/{user}/ban", [UserController::class, 'ban'])->name("ban");
                Route::post("/{user}/unban", [UserController::class, 'unban'])->name("unban");
                Route::post("/{user}/role", [UserController::class, 'role'])->name("role");
            });
            Route::group([
                'prefix' => "stats",
                "as" => "stats."
            ], function () {
                Route::get("", [StatsController::class, 'index'])->name("index");
            });
        });
    });
});
