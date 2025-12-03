<?php

namespace App\Modules\Admin\Services\Traits\Stats;

use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Entities\Models\Work;
use Illuminate\Support\Facades\DB;

trait HasJobStats
{

    public static function getJobCount()
    {
        return Work::count();
    }

    public static function getApplicationCount()
    {
        return Applicant::count();
    }

    public static function getJobCountByType()
    {
        return Work::select("type", DB::raw("count(*) as count"))
            ->groupBy('type')
            ->pluck('count', "type")
            ->toArray();
    }
}
