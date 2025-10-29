<?php

namespace App\Http\Controllers\Api\Qaulifications;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Qaulifications\StoreCourseRequest;
use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Auth;

class CourseController extends ApiController
{


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
}
