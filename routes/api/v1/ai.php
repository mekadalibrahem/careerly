<?php

use App\Modules\N8n\Http\Controllers\CvAnaliserController;
use App\Modules\N8n\Http\Controllers\RateApplicantController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",

], function () {
    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        // Route::post('/analyze-cv', [CvAnaliserController::class, 'analyzeCV']);
        Route::get('user/{user}/analyze-cv', [CvAnaliserController::class, 'analyzeCV'])->name("ai.user.analyzeCv");
        Route::get('user/{user}/analyze-cv-show', [CvAnaliserController::class, 'show'])->name("ai.user.analyzeCvShow");
        Route::post('/works/{work}/rateApplicants', [RateApplicantController::class, 'rate']);
    });
    Route::put('/cv-analysis-result', [CvAnaliserController::class, 'store']);
    Route::put('/rateApplicants-result', [RateApplicantController::class, 'store']);
});
