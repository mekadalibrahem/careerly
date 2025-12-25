<?php

namespace App\Modules\Exports\Policies;

use App\Models\User;
use App\Modules\Exports\Entities\Download;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Auth\Access\Response;

class DownloadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Download $model): bool
    {
        return $model->isOwnedBy($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Download $model): bool
    {

        return  $model->isOwnedBy($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Download $model): bool
    {

        return  $model->isOwnedBy($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Download $model): bool
    {

        return  $model->isOwnedBy($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Download $model): bool
    {
        return false;
    }
    public function exportCv(User $user)
    {
        return $user->hasPermissionTo(PermissionsKeyEnum::EXPORT_CV());
    }
}
