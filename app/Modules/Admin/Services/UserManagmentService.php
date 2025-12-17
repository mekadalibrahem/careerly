<?php

namespace App\Modules\Admin\Services;

use App\Models\User;
use App\Modules\Admin\Http\Resources\AdminUserResource;
use App\Modules\Admin\Services\Traits\HasBanUser;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\SoftDeletedEnum;

class UserManagmentService
{
    use HasBanUser;
    public static function getUser($id)
    {
        return User::find($id);
    }

    public static function getAllUser($params)
    {
        $query = User::query();
        $per_page = 10;
        // filters
        if ( array_key_exists('role', $params)) {
            $query->role($params['role']);
        }
        if ( array_key_exists('after_created_at', $params)) {
            $query->whereDate('created_at' , '>' , $params['after_created_at']);
        }
        if ( array_key_exists('before_created_at', $params)) {
            $query->whereDate('created_at' , '<' , $params['before_created_at']);
        }
        if ( array_key_exists('per_page', $params)) {
            $per_page =  $params['per_page'];
        }
        if ( array_key_exists('deleted', $params)) {
            switch ($params['deleted']) {
                case SoftDeletedEnum::DELETED_ONLY() :
                    $query->onlyTrashed();
                    break;
                case SoftDeletedEnum::WITH_DELETED():
                    $query->withTrashed();
                    break;
            }
        }
        if ( array_key_exists('email', $params)) {
            $query->whereLike('email', $params['email']);
        }
//
        return AdminUserResource::collection($query->paginate($per_page));
    }
    public static function deleteUser(User $user)
    {
        return $user->delete();
    }
    public static function roleUser(User $user,   $role)
    {
        $user->syncRoles($role);
        return true;
    }
}
