<?php

namespace App\Modules\Works\Http\Resources;

use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
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
            "status" => $this->status,
            'ai_rate' => $this->analyze()->where('type', AiAnalyzeTypeEnum::APPLICANT())->orderBy('updated_at', 'desc')->first()?->data ?? null,
            "work_id" => $this->work_id,
            "user_id" => $this->user_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            "user_profile" => [
                "bio" => $this->user->bio,
                'title' => $this->user->title,
            ]
        ];
    }
}
