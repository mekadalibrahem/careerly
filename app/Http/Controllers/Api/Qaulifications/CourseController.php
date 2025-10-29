<?php

namespace App\Http\Controllers\Api\Qaulifications;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Qaulifications\StoreCourseRequest;
use App\Http\Requests\Qaulifications\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class CourseController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        try {
            $courses = Course::where('user_id', $user->id)->get();
            if ($courses) {


                return $this->respondWithSuccess([
                    "courses" => $courses,
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
    public function show(User $user, Course $course)
    {
        try {
            if ($course) {


                return $this->respondWithSuccess([
                    "course" => $course,
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
    public function store(StoreCourseRequest $request)
    {

        $validation = $request->validated();
        try {
            $user =  Auth::user();

            $course = Course::create([
                'name' => $validation['name'],
                'provider' => $validation['provider'],
                'duration' => $validation['duration'],
                'url' => $validation['url'],
                'user_id' => $user->id
            ]);
            if ($course) {
                return $this->respondCreated([
                    "course" => $course
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
    public function update(UpdateCourseRequest $request, User $user, Course $course)
    {

        $validation = $request->validated();
        try {
            $course->name     = $validation['name'];
            $course->provider = $validation['provider'];
            $course->duration = $validation['duration'];
            $course->url      = $validation['url'];
            if ($course->save()) {
                return $this->respondWithSuccess([
                    "message" => "item updated",
                    "course" => $course
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
    public function destroy(User $user, Course $course)
    {
        try {
            if ($course) {

                $course->delete();
                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM DELETED  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
}
