<?php

namespace App\Modules\Works\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Entities\Dto\WorkUpdatingDto;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Http\Requests\IndexWorkRequest;
use App\Modules\Works\Http\Requests\StoreWorkRequest;
use App\Modules\Works\Http\Requests\UpdateWorkRequest;
use App\Modules\Works\Http\Resources\WorkResource;
use Exception;
use Illuminate\Support\Facades\Auth;

class WorkController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(IndexWorkRequest $request)
    {
        try {
            $validated = $request->validated();
            $query = Work::query()->with(['user', 'applicants']);
            // filters
            if (array_key_exists('recruiter_id', $validated)) {
                $query->where('user_id', $validated['recruiter_id']);
            }
            if (array_key_exists('type', $validated)) {
                $query->whereIn('type', $validated['type']);
            }
            if (array_key_exists('status', $validated)) {
                $query->where('status', $validated['status']);
            }
            // search

            if (array_key_exists('searchString' , $validated)) {
                $query->whereAny(['name','company','location','description','requirements'], 'LIKE', '%' . $validated['searchString'] . '%');
            }





            return WorkResource::collection($query->paginate(15));
        } catch (\Throwable $th) {
            return $this->respondError("FAILED ITEM DELETED " . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        try {
            if ($work) {


                return new WorkResource($work);
            }
            $this->respondNotFound("FAILED ITEM  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILED : " . $th->getMessage());
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
            $workDto = WorkUpdatingDto::fromArray($validation);
            $data = $workDto->toArray();
            $data['user_id'] = $user->id;
            $work = Work::create($data);
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
    public function update(UpdateWorkRequest $request, Work $work)
    {

        $validation = $request->validated();
        try {
            $workDto = WorkUpdatingDto::fromArray($validation);
            $update = $work->update($workDto->toArray());
            if ($update) {
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
            $this->respondNotFound("FAILED ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILED ITEM DELETED " . $th->getMessage());
        }
    }
}
