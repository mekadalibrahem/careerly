<?php

namespace App\Modules\Admin\Services;

use App\Models\User;
use App\Modules\Admin\Services\Traits\Stats\HasAIStatus;
use App\Modules\Admin\Services\Traits\Stats\HasJobStats;
use App\Modules\Admin\Services\Traits\Stats\HasUserStats;
use Illuminate\Support\Facades\Cache;

class StatsServices
{

    use HasUserStats;
    use HasJobStats;
    use HasAIStatus;

    public static string $CACHE_KEY_STATS_DASHBOARD_ADMIN =  "stats.dashboard";
    public static function getAllStat():array{

      
        
            return [
                //users_by_role
                "total_users"         => self::getUserCount(),
                "users_by_role"          => self::getUserCountByRole(),
                "total_jobs"  => self::getJobCount(),
                "total_applications"       => self::getApplicationCount(),
                "jobs_by_type"        => self::getJobCountByType(),
                "recent_registrations" => self::getUserResentRegisteration(),
                "ai" => [
                    "request_by_status" => self::AIRequestcountByStatus(),
                    "request_by_types"  => self::AIRequestcountByType(),
                ]
            ];
    
      

    }
}
