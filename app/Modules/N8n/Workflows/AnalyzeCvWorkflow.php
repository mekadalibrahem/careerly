<?php

namespace App\Modules\N8n\Workflows;

use App\Models\User;
use App\Modules\N8n\Contracts\WorkflowHandlerInterface;
use App\Modules\N8n\N8nClient;

class AnalyzeCvWorkflow implements WorkflowHandlerInterface
{
    public function __construct(private N8nClient $client) {}

    public function handle(array $payload): array
    {
        return $this->client->call('cvAnalize', $payload);
    }
    public static function preperPayload($user_id)
    {
        $user = User::where('id', $user_id)
            ->with(['skills', 'projects', 'courses', 'educations'])
            ->first();

        if (!$user) {
            return null; // or throw an exception
        }

        // Format skills: group by category (assuming 'name' is the category)
        $skills = $user->skills->map(function ($skill) {

            return [
                'name' => $skill->name,

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
