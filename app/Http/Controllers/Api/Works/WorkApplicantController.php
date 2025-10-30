<?php

namespace App\Http\Controllers\Api\Works;

use App\Http\Controllers\Api\ApiController;
use App\Models\Applicant;
use App\Models\User;
use App\Models\Work;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Enums\WorkStatusEnum;
use App\Modules\Works\Services\WorkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkApplicantController extends ApiController
{


    /**
     * Display a listing of the resource.
     */
    public function index(Work $work)
    {

        try {
            $authedUser = Auth::user();

            if ($work->isOwnedBy($authedUser)) {
                $applicants = $work->applicants;

                if ($applicants) {
                    // $applicants = $applicants->count() > 0 ? $applicants : [];
                    return $this->respondWithSuccess([
                        "applicants" => $applicants,
                    ]);
                }
            } else {
                return $this->respondUnAuthenticated();
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Work $work, Applicant $applicant)
    {

        try {
            $authedUser = Auth::user();
            if ($authedUser->id == $work->user_id) {
                if ($applicant) {


                    return $this->respondWithSuccess([
                        "applicant" => $applicant,
                    ]);
                }
            } else {
                return $this->respondUnAuthenticated();
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
    public function selectApplicant(Request $request, Work $work)
    {
        try {
            $user = User::find($request['user_id']);
            if ($user) {
                // return "true";
                $hr = Auth::user();
                if ($hr->role == UserRolesEnums::HR() && $work->isOwnedBy($hr)) {
                    $applicant = Applicant::where([
                        "work_id" => $work->id,
                        "user_id" => $user->id
                    ])->first();
                    if ($applicant && $user) {
                        $applicant->accepted = 1;
                        $applicant->save();
                        $work->status = WorkStatusEnum::END();
                        $work->save();
                        return $this->respondWithSuccess(["message" => "applicant selected"]);
                    } else {
                        return $this->respondNotFound("user not register for this work");
                    }
                } else {
                    return $this->respondForbidden();
                }
            } else {
                return $this->respondNotFound("user not found");
            }
        } catch (\Throwable $th) {
            $this->respondError("ACTION FAILD" . $th->getMessage());
        }
    }
}
