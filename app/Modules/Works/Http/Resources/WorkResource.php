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

        ];
    }
}
