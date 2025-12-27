<?php

namespace App\Modules\Qualifications\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;

use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Project;
use App\Modules\Qualifications\Http\Requests\StoreProjectRequest;
use App\Modules\Qualifications\Http\Requests\UpdateProjectRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProjectController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        try {
            $projects = Project::where('user_id', $user->id)->get();
            if ($projects) {


                return $this->respondWithSuccess([
                    "projects" => $projects,
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
    public function show(User $user, Project $project)
    {
        try {
            if ($project) {


                return $this->respondWithSuccess([
                    "project" => $project,
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
    public function store(StoreProjectRequest $request)
    {

        $validation = $request->validated();
        try {
            $user =  Auth::user();

            $project = Project::create([
                'name' => $validation['name'],
                'description' => $validation['description'],
                'tools' => $validation['tools'],
                'url' => $validation['url']?? null,
                'user_id' => $user->id
            ]);
            if ($project) {
                return $this->respondCreated([
                    "project" => $project
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
    public function update(UpdateProjectRequest $request, User $user, Project $project)
    {

        $validation = $request->validated();
        try {
            $project->name     = $validation['name'];
            $project->description = $validation['description'];
            $project->tools     = $validation['tools'];
            $project->url      = $validation['url']?? null;
            if ($project->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "project" => $project
                ]);
            } else {
                return $this->respondError("ERROR UPDATE project ");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR UPDATE project " . $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Project $project)
    {
        try {
            if ($project) {

                $project->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
