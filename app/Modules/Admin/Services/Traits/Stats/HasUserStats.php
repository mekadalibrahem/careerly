<?php

namespace App\Modules\Admin\Services\Traits\Stats;

use App\Models\User;
use Illuminate\Support\Facades\DB;

trait HasUserStats
{



    public static function getUserCount()
    {
        return User::count();
    }

    public static function getUserCountByRole()
    {
        return User::select('role', DB::raw("count(*) as total"))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();
    }

    public static function getUserResentRegisteration()
    {
        return User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
