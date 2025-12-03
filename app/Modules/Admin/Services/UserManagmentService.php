<?php

namespace App\Modules\Admin\Services;

use App\Models\User;
use App\Modules\Admin\Services\Traits\HasBanUser;
use App\Modules\Users\Enums\UserRolesEnums;

class UserManagmentService
{
    use HasBanUser;
    public static function getUser($id)
    {
        return User::find($id);
    }

    public static function getAllUser()
    {
        return User::all();
    }
    public static function deleteUser(User $user)
    {
        return $user->delete();
    }
    public static function roleUser(User $user,   $role)
    {
        $user->role = $role;
        return $user->save();
    }
}
