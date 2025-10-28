<?php

namespace App\Http\Controllers\Api\Qaulifications;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Qaulifications\StoreSkillRequest;
use App\Http\Requests\Qaulifications\UpdateSkillRequest;

use App\Models\Skill;
use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Exception;
use Illuminate\Support\Facades\Auth;

class SkillController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'user_id' => $user->id
            ]);
            if ($skill) {
                return $this->respondCreated([
                    "skill" => $skill
                ]);
            } else {
                return $this->respondError("ERROR TO STORE YOUR SKILL");
            }
        } catch (Exception $e) {
            return $this->respondError("ERROR TO STORE YOUR SKILL" . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, User $user, Skill $skill)
    {

        $validation = $request->validated();
        try {
            $skill->name = $validation['name'];
            if ($skill->save()) {
                return $this->respondWithSuccess([
                    "message" => "skill updated",
                    "skill" => $skill
                ]);
            } else {
                return $this->respondError("ERROR UPDATE SKILL ");
            }
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
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
