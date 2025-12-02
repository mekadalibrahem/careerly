<?php

namespace App\Modules\Works\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Models\WorkRequirment;
use App\Modules\Works\Http\Requests\StoreWorkRequirmentRequest;
use App\Modules\Works\Http\Requests\UpdateWorkRequirmentRequest;
use Exception;


class WorkRequirmentController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(Work $work)
    {
        try {
            $workRequirment = WorkRequirment::where('work_id', $work->id)->get();
            if ($workRequirment) {
                return $this->respondWithSuccess([
                    "workRequirment" => $workRequirment,
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
    public function show(Work $work, WorkRequirment $workRequirment)
    {
        try {
            if ($workRequirment) {


                return $this->respondWithSuccess([
                    "workRequirment" => $workRequirment,
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
    public function store(StoreWorkRequirmentRequest $request, Work $work)
    {

        $validation = $request->validated();
        try {

            $workRequirment = WorkRequirment::create([
                'name' => $validation['name'],
                'description' => $validation['description'],
                'level' => $validation['level'],
                'work_id' => $work->id
            ]);
            if ($workRequirment) {
                return $this->respondCreated([
                    "workRequirment" => $workRequirment
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
    public function update(UpdateWorkRequirmentRequest $request, Work $work, WorkRequirment $workRequirment)
    {

        $validation = $request->validated();
        try {
            $workRequirment->name     = $validation['name'];
            $workRequirment->description = $validation['description'];
            $workRequirment->level = $validation['level'];
            if ($workRequirment->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "workRequirment" => $workRequirment
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
    public function destroy(Work $work, WorkRequirment $workRequirment)
    {
        try {
            if ($workRequirment) {
                $workRequirment->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
