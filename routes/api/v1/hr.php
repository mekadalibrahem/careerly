<?php

use App\Modules\Works\Http\Controllers\Api\WorkApplicantController;
use App\Modules\Works\Http\Controllers\Api\WorkApplicantManagmentController;
use App\Modules\Works\Http\Controllers\Api\WorkController;
use App\Modules\Works\Http\Controllers\Api\WorkRequirementController;
use App\Modules\Works\Http\Controllers\Api\WorkStatusController;
use App\Modules\Works\Http\Controllers\Api\WorkTypesController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",
    "middleware" => [],
], function () {
    Route::get("works/types", [WorkTypesController::class, 'index'])->name("works.types");
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::put("works/{work}/activate", [WorkStatusController::class, 'activate'])->name("works.activate");
        Route::put("works/{work}/close", [WorkStatusController::class, 'close'])->name("works.close");
        Route::apiResource("works", WorkController::class);

        Route::apiResource("works/{work}/workRequirements", WorkRequirementController::class);
        Route::get("works/{work}/applicants/{applicant}", [WorkApplicantController::class, 'show'])->name('works.applicants.show');
        Route::get("works/{work}/applicants", [WorkApplicantController::class, 'index'])->name('works.applicants.index');
        // Route::post("works/{work}/selectApplicant", [WorkApplicantController::class, 'selectApplicant'])->name('works.applicants.selectApplicant');
        Route::put("works/{work}/applicants/{applicant}/reject", [WorkApplicantManagmentController::class, 'reject'])->name('works.applicants.reject');
        Route::put("works/{work}/applicants/{applicant}/select", [WorkApplicantManagmentController::class, 'select'])->name('works.applicants.select');
      
    });
});
