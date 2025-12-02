<?php

// Route::put('/users/{id}', [UserController::class, 'update'])->middleware('auth:api');
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\AccountController;

use App\Http\Controllers\Api\Works\UserApplicantController;
use App\Modules\Qualifications\Http\Controllers\Api\CourseController;
use App\Modules\Qualifications\Http\Controllers\Api\EducationController;
use App\Modules\Qualifications\Http\Controllers\Api\ProjectController;
use App\Modules\Qualifications\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;



Route::group([
    "prefix" => "v1",
    "middleware" => [],
], function () {
    Route::group([
        'prefix' => "user",
        'as' => 'user.',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::put('/{id}/password/update', [AccountController::class, 'updatePassword'])->name('password.update');
        Route::put('/{id}/update', [AccountController::class, 'updateAccount'])->name('account.update');
        Route::apiResource('/{user}/skills', SkillController::class);
        Route::apiResource("/{user}/courses", CourseController::class);
        Route::apiResource("/{user}/projects", ProjectController::class);
        Route::apiResource("/{user}/educations", EducationController::class);
        Route::apiResource("/{user}/applicants", UserApplicantController::class);
    });
});
