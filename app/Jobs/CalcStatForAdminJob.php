<?php

namespace App\Jobs;

use App\Modules\Admin\Services\StatsServices;
use App\Modules\Exports\Entities\Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CalcStatForAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        try{
            Cache::forget(StatsServices::$CACHE_KEY_STATS_DASHBOARD_ADMIN);
            $stats = StatsServices::getAllStat();

        }catch (\Throwable $th){
            logger()->error(__CLASS__ . " " . $th->getMessage());
        }
    }
}
