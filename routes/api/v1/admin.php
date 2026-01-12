<?php

use App\Http\Middlewares\BanUserMiddleware;
use App\Modules\Admin\Http\Controllers\Api\StatsController;
use App\Modules\Admin\Http\Controllers\Api\UserController;
use App\Modules\Admin\Http\Middleware\HasAdminRoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Http\Controllers\Api\AdminSupportTicketsController;

Route::group([
    "prefix" => "v1",

], function () {
    Route::group([
        'middleware' => ['auth:sanctum', HasAdminRoleMiddleware::class, BanUserMiddleware::class],
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
            Route::group([
                'prefix' => "support",
                "as" => "support."
            ], function () {
                Route::get("/", [AdminSupportTicketsController::class, 'index'])->name("index");
                Route::get("/{supportTicket}", [AdminSupportTicketsController::class, 'show'])->name("show");
                Route::put("/{supportTicket}/updateStatus", [AdminSupportTicketsController::class, 'updateStatus'])->name("update-status");
                Route::put("/{supportTicket}/updateNote", [AdminSupportTicketsController::class, 'updateNote'])->name("update-note");
            });
            Route::get("/roles" , [\App\Modules\Admin\Http\Controllers\Api\AdminRoleController::class, 'index'])->name("roles.index");
        });
    });
});
