<?php

namespace App\Modules\Qualifications\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;

use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Education;
use App\Modules\Qualifications\Http\Requests\StoreEducationRequest;
use App\Modules\Qualifications\Http\Requests\UpdateEducationRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class EducationController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        try {
            $educations = Education::where('user_id', $user->id)->get();
            if ($educations) {


                return $this->respondWithSuccess([
                    "educations" => $educations,
                ]);
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user, Education $education)
    {
        try {
            if ($education) {


                return $this->respondWithSuccess([
                    "education" => $education,
                ]);
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationRequest $request)
    {

        $validation = $request->validated();
        try {
            $user =  Auth::user();

            $education = Education::create([
                'name' => $validation['name'],
                'institution' => $validation['institution'],
                'degree' => $validation['degree'],
                'grade' => $validation['grade'],
                'start_at' => $validation['start_at'],
                'end_at' => $validation['end_at'] ?? null,
                'user_id' => $user->id
            ]);
            if ($education) {
                return $this->respondCreated([
                    "education" => $education
                ]);
            } else {
                return $this->respondError("ERROR TO STORE");
            }
        } catch (Exception $e) {
            return $this->respondError("ERROR TO STORE" . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, User $user, Education $education)
    {

        $validation = $request->validated();
        try {
            $education->name     = $validation['name'];
            $education->institution = $validation['institution'];
            $education->degree = $validation['degree'];
            $education->grade      = $validation['grade'];
            $education->start_at      = $validation['start_at'];
            $education->end_at      = $validation['end_at']?? null;
            if ($education->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "education" => $education
                ]);
            } else {
                return $this->respondError("ERROR UPDATE education ");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR UPDATE education " . $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Education $education)
    {
        try {
            if ($education) {

                $education->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
