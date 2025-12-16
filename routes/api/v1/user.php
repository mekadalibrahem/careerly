<?php


use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\UserNotificationController;
use App\Modules\Qualifications\Http\Controllers\Api\CourseController;
use App\Modules\Qualifications\Http\Controllers\Api\EducationController;
use App\Modules\Qualifications\Http\Controllers\Api\ProjectController;
use App\Modules\Qualifications\Http\Controllers\Api\SkillController;
use App\Modules\Works\Http\Controllers\Api\UserApplicantController;
use App\Modules\Works\Http\Controllers\Api\WorkApplicantManagmentController;
use Illuminate\Support\Facades\Route;
use App\Modules\Exports\Http\Controllers\DownloadManagerController;


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
        Route::put("/{user}/applicants/{applicant}/accept", [WorkApplicantManagmentController::class, 'accept'])->name('users.applicants.accept');
        Route::get("/{user}/notifications", [UserNotificationController::class, 'index']);
        Route::get("/{user}/notifications/{id}", [UserNotificationController::class, 'show']);
        Route::delete("/{user}/notifications", [UserNotificationController::class, 'destroyAll']);
        Route::delete("/{user}/notifications/{id}", [UserNotificationController::class, 'destroy']);
        Route::put("/{user}/notifications/markReadAll", [UserNotificationController::class, 'markdReadAll']);
        Route::put("/{user}/notifications/{id}/markRead", [UserNotificationController::class, 'markdRead']);
        Route::get('/{user}/export-cv', [DownloadManagerController::class , 'store'])->name("export-cv.store");
        Route::get("/{user}/downloads/{download}" , [DownloadManagerController::class , 'download'])->name("files.download");
    });
});
