<?php

namespace App\Modules\Works\Policies;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Enums\ApplicantStatusEnum;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Auth\Access\Response;

class ApplicantPolicy
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
    public function view(User $user, Applicant $applicant): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsKeyEnum::APPLY_TO_JOB());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Applicant $applicant): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Applicant $applicant): bool
    {
        return $applicant->isOwnedBy($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Applicant $applicant): bool
    {
        return $applicant->isOwnedBy($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Applicant $applicant): bool
    {
        return $applicant->isOwnedBy($user);
    }

    public  function reject(User $user ,Applicant $applicant, Work $work):bool
    {
        if ($user->is($work->user) && $applicant->work->is($work)) {
            if  ($applicant->status == null) {
                return true;
            }
            if (in_array($applicant->status, [
                ApplicantStatusEnum::PENDING(),
                ApplicantStatusEnum::REJECTED()
            ], true)){
                return  true;
            }
        }
        return  false;
    }
    public  function accept(User $user ,Applicant $applicant):bool
    {
        if ($applicant->user->is($user) ) {
            if ($applicant->status == ApplicantStatusEnum::PENDING()) {
                return true;
            }
        }
        return  false;
    }
    public  function select(User $user ,Applicant $applicant, Work $work):bool
    {
        if ($user->is($work->user) && $applicant->work->is($work)) {
            if  ($applicant->status == null) {
                return true;
            }
            if (in_array($applicant->status, [
                ApplicantStatusEnum::PENDING(),
                ApplicantStatusEnum::REJECTED()
            ], true)){
                return  true;
            }
        }
        return  false;
    }
}
