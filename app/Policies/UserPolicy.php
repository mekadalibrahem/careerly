<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // user can update own account
        if($user->is($model) ){
            return  true;
        }
        // no one can change super admin information
        if( $model->hasRole(UserRolesEnums::SUPER_ADMIN())){
           if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_ADMINS())){
               return true;
           }

            return false;
        }

        if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // no one can change super admin information
        if( $model->hasRole(UserRolesEnums::SUPER_ADMIN())){
            if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_ADMINS())){
                // if last super admin return false  can't delete it
               return (User::role(UserRolesEnums::SUPER_ADMIN())->count() > 1);
            }

            return false;
        }

        if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // no one can change super admin information
        if( $model->hasRole(UserRolesEnums::SUPER_ADMIN())){
            if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_ADMINS())){
                return true;
            }

            return false;
        }

        if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
    public function updateRole(User $user , User $model)
    {
        // no one can change super admin information
        if( $model->hasRole(UserRolesEnums::SUPER_ADMIN())){
            if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_ADMINS())){
                // if last super admin return false  can't delete it
                return (User::role(UserRolesEnums::SUPER_ADMIN())->count() > 1);
            }

            return false;
        }

        if($user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())){
            return true;
        }

        return false;
    }
}
