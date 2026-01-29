<?php

namespace App\Modules\Qualifications;

use App\Models\User;
use InvalidArgumentException;

class QualificationsHelper
{

    public static function preperForAi($user_id)
    {
        try{

        
        if ($user_id < 1) {
            throw new InvalidArgumentException();
        }
       
        $user = User::where('id', $user_id)
            ->with(['skills', 'projects', 'courses', 'educations'])
            ->first();
        
        if (!$user) {
            return null;
            throw new InvalidArgumentException();
        }
       
        // Format skills: 
        $skills = $user->skills->map(function ($skill) {

            return [
                'name' => $skill->name ,
                'level' => $skill->level,
            ];
        })->values();

        // Format projects
        $projects = $user->projects->map(function ($project) {
            return [
                'name' => $project->name,
                'description' => $project->description,
                'technologies' => $project->tools ? explode(', ', $project->tools) : [],
                'year' =>  $project->created_at ? $project->created_at->format('Y') : "", 
                // 'url' => $project->url,
            ];
        })->values();

        // Format courses
        $courses = $user->courses->map(function ($course) {
            return [
                'name' => $course->name,
                'platform' => $course->provider,
                'completionYear' =>  $course->created_at ? $course->created_at->format('Y') :"", 
                // 'url' => $course->url,
            ];
        })->values();

        // Format educations
        $educations = $user->educations->map(function ($edu) {
            return [
                'degree' => $edu->name, 
                'institution' => $edu->institution,
                "degree" => $edu->degree,
                'grade' => $edu->grade,
                "start year" => $edu->start_at,
                'end year' => $edu->end_at ?? null,
            ];
        })->values();

        return [
            'user_id' => $user->id,
            'jobTitle' => $user->title,
            'educations' => $educations,
            'courses' => $courses,
            'projects' => $projects,
            'skills' => $skills,
        ];
         }catch(\Throwable $th){
            logger()->error("error preper for ai 4 :" . $th->getMessage());
             return null;
            throw $th;
         }
    }
}
