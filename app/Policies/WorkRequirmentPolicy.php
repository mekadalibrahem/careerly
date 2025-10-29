<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;
use App\Models\WorkRequirment;
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
    public function view(User $user, WorkRequirment $workRequirment): bool
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
    public function update(User $user, Work $work, WorkRequirment $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Work $work, WorkRequirment $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Work $work, WorkRequirment $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Work $work, WorkRequirment $workRequirment): bool
    {
        if ($work->isOwnedBy($user) && $work->id = $workRequirment->work_id) {
            return true;
        }
        return false;
    }
}
