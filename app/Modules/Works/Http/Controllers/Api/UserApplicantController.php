<?php

namespace App\Modules\Works\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use App\Models\User;
use App\Modules\Works\Entities\Models\Applicant;
use App\Modules\Works\Http\Requests\StoreUserApplicantRequest;
use App\Modules\Works\Http\Requests\UpdateUserApplicantRequest;
use Illuminate\Support\Facades\Auth;

class UserApplicantController extends ApiController
{


    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        try {
            $authedUser = Auth::user();
            if ($authedUser->can('viewAny', Applicant::class)) {
                $applicants = $user->applicants;
                if ($applicants) {


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
    public function show(User $user, Applicant $applicant)
    {
        try {
            if ($applicant) {


                return $this->respondWithSuccess([
                    "applicant" => $applicant,
                ]);
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
    public function store(StoreUserApplicantRequest $request, User $user)
    {
        $validation = $request->validated();
        try {
            $applicant = Applicant::create([
                "user_id" => $user->id,
                "work_id" => $validation["work_id"],
            ]);
            if ($applicant) {
                return $this->respondCreated([
                    "applicant" => $applicant
                ]);
            } else {
                return $this->respondError("ERROR TO STORE");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR UPDATE course " . $th->getMessage());
        }
    }
    public function update(UpdateUserApplicantRequest $request, User $user, Applicant $applicant)
    {
        return $this->respondNotFound("This Action Is Not  Supported");
    }
    public function destroy(User $user, Applicant $applicant)
    {
        try {
            if ($applicant) {
                $authedUser = Auth::user();
                if ($authedUser->can('delete', $applicant)) {
                    $applicant->delete();
                    return $this->respondOk("Item deleted");
                } else {
                    return $this->respondUnAuthenticated();
                }
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
