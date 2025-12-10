<?php

namespace App\Modules\Works\Http\Controllers\Api;

use App\Events\ApplicantAccepted;
use App\Events\ApplicantRejected;
use App\Events\ApplicantSelected;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Enums\ApplicantStatusEnum;
use App\Modules\Works\Http\Requests\ApplicantStatus\AcceptApplicantRequest;
use App\Modules\Works\Http\Requests\ApplicantStatus\RejectApplicantRequest;
use App\Modules\Works\Http\Requests\ApplicantStatus\SelectApplicantRequest;

class WorkApplicantManagmentController extends ApiController
{

    public function reject(RejectApplicantRequest $request, Work $work, Applicant $applicant)
    {
        try {
            $request->validated();

            $applicant->status = ApplicantStatusEnum::REJECTED();
            if ($applicant->save()) {
                event(new ApplicantRejected($applicant->id));
                return $this->respondOk("applicant rejected");
            } else {

                return $this->respondError("ERROR FAILD to reject applicant");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  :"  . $th->getMessage());
        }
    }
    public function select(SelectApplicantRequest $request, Work $work, Applicant $applicant)
    {
        try {
            $request->validated();
            $applicant->status = ApplicantStatusEnum::PENDING();
            if ($applicant->save()) {
                event(new ApplicantSelected($applicant->id));
                return $this->respondOk("applicant selected");
            } else {

                return $this->respondError("ERROR FAILD to select applicant");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  :"  . $th->getMessage());
        }
    }
    public function accept(AcceptApplicantRequest $request, User $user, Applicant $applicant)
    {
        try {
            $request->validated();
            $applicant->status = ApplicantStatusEnum::ACCEPTED();
            if ($applicant->save()) {
                event(new ApplicantAccepted($applicant->id));
                return $this->respondOk("applicant accpted");
            } else {

                return $this->respondError("ERROR FAILD to accept applicant");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  :"  . $th->getMessage());
        }
    }
}
