<?php

namespace App\Modules\Works\Policies;


use App\Models\User;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Models\WorkRequirement;
use Illuminate\Auth\Access\Response;

class WorkRequirmentPolicy
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
    public function view(User $user, WorkRequirement $workRequirment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Work $work): bool
    {

        return $work->isOwnedBy($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Work $work, WorkRequirement $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Work $work, WorkRequirement $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Work $work, WorkRequirement $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Work $work, WorkRequirement $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }
}
