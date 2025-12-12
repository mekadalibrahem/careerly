<?php

namespace App\Modules\Admin\Services;

use App\Models\User;
use App\Modules\Admin\Services\Traits\Stats\HasAIStatus;
use App\Modules\Admin\Services\Traits\Stats\HasJobStats;
use App\Modules\Admin\Services\Traits\Stats\HasUserStats;

class StatsServices
{

    use HasUserStats;
    use HasJobStats;
    use HasAIStatus;

    public static function getAllStat():array{
        
        return  [
            "total_users" =>self::getUserCount(),
            "total_jobs" =>   self::getUserCountByRole(),
            "total_applications" => self::getJobCount(),
            "users_by_role" => self::getApplicationCount(),
            "jobs_by_type" => self::getJobCountByType(),
            "recent_registrations" => self::getUserResentRegisteration(),
            "ai" => [
                "request_by_status" => self::AIRequestcountByStatus(),
            ]
        ];
    }
}
