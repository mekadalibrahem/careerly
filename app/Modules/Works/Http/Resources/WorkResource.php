<?php

namespace App\Modules\Works\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->type,
            "description" => $this->description,
            "company" => $this->company,
            "location" => $this->location,
            "salary_range" => $this->salary_range,
            "requirements" => $this->requirements,
            'benefits' => $this->benefits,
            "status" => $this->status,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'has_applied' => $this->appliedCount() ? true : false,
            'applied_count' => $this->appliedCount(),
            'has_pending' => $this->pendingCount() ? true : false,
            'pending_count' => $this->pendingCount(),
            'applications_count' => $this->applicants()->count(),
            'recruiter' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'title' => $this->user->title,
                'bio' => $this->user->bio,
            ],

        ];
    }
}
