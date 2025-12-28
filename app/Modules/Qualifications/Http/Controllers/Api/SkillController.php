<?php

namespace App\Modules\Qualifications\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Skill;
use App\Modules\Qualifications\Http\Requests\StoreSkillRequest;
use App\Modules\Qualifications\Http\Requests\UpdateSkillRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class SkillController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        try {
            $skills = Skill::where('user_id', $user->id)->get();
            if ($skills) {


                return $this->respondWithSuccess([
                    "skills" => $skills,
                ]);
            }
            return  $this->respondNotFound("FAILED ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            return $this->respondError("FAILED ITEM DELETED " . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {

        $validation = $request->validated();
        try {
            $user =  Auth::user();

            $skill = Skill::create([
                'name' => $validation['name'],
                "level" =>$validation['level'],
                'user_id' => $user->id
            ]);
            if ($skill) {
                return $this->respondCreated([
                    "skill" => $skill
                ]);
            }

            return $this->respondError("ERROR TO STORE YOUR SKILL");
        } catch (Exception $e) {
            return $this->respondError("ERROR TO STORE YOUR SKILL" . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Skill $skill)
    {
        try {
            if ($skill) {


                return $this->respondWithSuccess([
                    "skill" => $skill,
                ]);
            }
            $this->respondNotFound("FAILED ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILED ITEM DELETED " . $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, User $user, Skill $skill)
    {

        $validation = $request->validated();
        try {
            $skill->name = $validation['name'];
            $skill->level = $validation['level'];
            if ($skill->save()) {
                return $this->respondWithSuccess([
                    "message" => "skill updated",
                    "skill" => $skill
                ]);
            }

            return $this->respondError("ERROR UPDATE SKILL ");
        } catch (\Throwable $th) {
            return $this->respondError("ERROR UPDATE SKILL " . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Skill $skill)
    {
        try {
            if ($skill) {

                $skill->delete();
                return $this->respondOk("Item deleted");
            }
            return $this->respondNotFound("FAILED ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            return   $this->respondError("FAILED ITEM DELETED " . $th->getMessage());
        }
    }
}
