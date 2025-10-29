<?php

namespace App\Http\Controllers\Api\Works;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Work\StoreWorkRequest;
use App\Http\Requests\Work\UpdateWorkRequest;
use App\Models\Work;
use App\Modules\Works\Enums\WorkStatusEnum;
use Exception;
use Illuminate\Support\Facades\Auth;

class WorkController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $works = Work::where('user_id', $user->id)->get();
            if ($works) {


                return $this->respondWithSuccess([
                    "works" => $works,
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
    public function show(Work $work)
    {
        try {
            if ($work) {


                return $this->respondWithSuccess([
                    "work" => $work,
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
    public function store(StoreWorkRequest $request)
    {

        $validation = $request->validated();
        try {
            $user =  Auth::user();

            $work = Work::create([
                'name' => $validation['name'],
                'description' => $validation['description'],
                'status' => WorkstatusEnum::RUNNING(),
                'user_id' => $user->id
            ]);
            if ($work) {
                return $this->respondCreated([
                    "work" => $work
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
    public function update(UpdateworkRequest $request, Work $work)
    {

        $validation = $request->validated();
        try {
            $work->name     = $validation['name'];
            $work->description = $validation['description'];
            if ($work->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "work" => $work
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
    public function destroy(Work $work)
    {
        try {
            if ($work) {
                $work->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
