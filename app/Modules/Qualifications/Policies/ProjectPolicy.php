<?php

namespace App\Modules\Qualifications\Policies;

use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Project;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
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
    public function view(User $user, Project $project): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsKeyEnum::MANAGE_PROFILE());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $project->isOwnedBy($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $project->isOwnedBy($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $project->isOwnedBy($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $project->isOwnedBy($user);
    }
}
