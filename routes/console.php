<?php

use App\Jobs\ClearWorkflowCallsAsTimeout;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(new ClearWorkflowCallsAsTimeout)->daily();
Schedule::job(new \App\Jobs\ClearExpiredTempDownloadFilesJob())->daily();
// Schedule::job(new \App\Jobs\CalcStatForAdminJob())->everyFifteenMinutes();
