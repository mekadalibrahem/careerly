<?php

namespace App\Http\Controllers\Api\Works;

use App\Http\Controllers\Api\ApiController;
use App\Models\Applicant;
use App\Models\Work;
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
}
