<?php

namespace App\Modules\Works\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Models\WorkRequirement;
use App\Modules\Works\Http\Requests\StoreWorkRequirementRequest;
use App\Modules\Works\Http\Requests\UpdateWorkRequirementRequest;
use Exception;


class WorkRequirementController extends ApiController
{

    /**
     * Display a listing of the resource. Requirements
     */
    public function index(Work $work)
    {
        try {
            $workRequirement = WorkRequirement::where("work_id", $work->id)->get();
            if ($workRequirement) {
                return $this->respondWithSuccess([
                    "workRequirement" => $workRequirement,
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
    public function show(Work $work, WorkRequirement $workRequirement)
    {
        try {
            if ($workRequirement) {


                return $this->respondWithSuccess([
                    "workRequirement" => $workRequirement,
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
    public function store(StoreWorkRequirementRequest $request, Work $work)
    {

        $validation = $request->validated();
        try {

            $workRequirement = WorkRequirement::create([
                'name' => $validation['name'],
                'description' => $validation['description'],
                'level' => $validation['level'],
                'work_id' => $work->id
            ]);
            if ($workRequirement) {
                return $this->respondCreated([
                    "workRequirement" => $workRequirement
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
    public function update(UpdateWorkRequirementRequest $request, Work $work, WorkRequirement $workRequirement)
    {

        $validation = $request->validated();
        try {
            $workRequirement->name     = $validation['name'];
            $workRequirement->description = $validation['description'];
            $workRequirement->level = $validation['level'];
            if ($workRequirement->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "workRequirement" => $workRequirement
                ]);
            } else {
                return $this->respondError("ERROR UPDATE course ");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR UPDATE course " . $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work, WorkRequirement $workRequirement)
    {
        try {
            if ($workRequirement) {
                $workRequirement->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
