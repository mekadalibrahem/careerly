<?php

namespace App\Modules\Admin\Services\Traits\Stats;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

trait HasUserStats
{



    public static function getUserCount()
    {
        return User::count();
    }

    public static function getUserCountByRole()
    {
        return Role::query()
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name as role', DB::raw('COUNT(model_has_roles.model_id) as total'))
            ->groupBy('roles.name')
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
