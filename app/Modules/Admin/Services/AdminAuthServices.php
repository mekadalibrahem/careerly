<?php

namespace App\Modules\Admin\Services;

use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Support\Facades\Auth;

final class AdminAuthServices
{


    public static function AuthAdminRole(): bool
    {
        $user = Auth::user();
        if ($user  && $user->hasAnyRole(UserRolesEnums::SUPER_ADMIN(), UserRolesEnums::ADMIN())) {
            return true;
        } else {
            return false;
        }
    }
}
