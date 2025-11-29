<?php

use App\Modules\N8n\Http\Controllers\CvAnaliserController;
use App\Modules\N8n\Http\Controllers\WorkFlowController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "v1",
    
], function () {
    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::post('/analyze-cv', [CvAnaliserController::class, 'analyzeCV']);
    });
    Route::put('/cv-analysis-result', [CvAnaliserController::class, 'store']);
});
