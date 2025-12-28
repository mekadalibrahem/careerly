<?php

namespace App\Modules\Qualifications;

use App\Models\User;
use InvalidArgumentException;

class QualificationsHelper
{

    public static function preperForAi($user_id)
    {
        if ($user_id < 1) {
            throw new InvalidArgumentException();
        }
        $user = User::where('id', $user_id)
            ->with(['skills', 'projects', 'courses', 'educations'])
            ->first();

        if (!$user) {
            throw new InvalidArgumentException();
        }

        // Format skills: group by category (assuming 'name' is the category)
        $skills = $user->skills->map(function ($skill) {

            return [
                'name' => $skill->name,
                'level' => $skill->level,
            ];
        })->values();

        // Format projects
        $projects = $user->projects->map(function ($project) {
            return [
                'name' => $project->name,
                'description' => $project->description,
                'technologies' => $project->tools ? explode(', ', $project->tools) : [],
                'year' => $project->created_at->format('Y'), // or use a dedicated year field if available
                // 'url' => $project->url, // include if public
            ];
        })->values();

        // Format courses
        $courses = $user->courses->map(function ($course) {
            return [
                'name' => $course->name,
                'platform' => $course->provider,
                'completionYear' => $course->created_at->format('Y'), // or use actual completion year if stored
                // 'url' => $course->url,
            ];
        })->values();

        // Format educations
        $educations = $user->educations->map(function ($edu) {
            return [
                'degree' => $edu->name, // e.g., "B.Sc. Computer Science"
                'institution' => $edu->institution,
                'year' => $edu->end_at ? substr($edu->end_at, 0, 4) : null,
                // 'grade' => $edu->grade, // include if needed
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
    }
}
