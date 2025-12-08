<?php

namespace App\Modules\Works\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Entities\DTOs\WorkRegistrationDTO;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Http\Requests\StoreWorkRequest;
use App\Modules\Works\Http\Requests\UpdateWorkRequest;
use App\Modules\Works\Http\Resources\WorkResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class WorkController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Work::query();
            if ($request->has('recruiter_id') && $request->recruiter_id != null) {
                $query->where('user_id', $request->recruiter_id);
            }
            if ($request->has('type') &&  $request->type != null) {
                $query->where('type', $request->type);
            }
            if ($request->has('status') && $request->status != null) {
                $query->where('status', $request->status);
            }


            return WorkResource::collection($query->paginate(15));
        } catch (\Throwable $th) {
            return $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
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
            $this->respondNotFound("FAILD ITEM  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD : " . $th->getMessage());
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
            $workDto = WorkRegistrationDTO::fromArray($validation);
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
            $workDto = WorkRegistrationDTO::fromArray($validation);
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
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
