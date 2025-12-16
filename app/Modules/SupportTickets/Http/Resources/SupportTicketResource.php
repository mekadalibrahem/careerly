<?php

namespace App\Modules\SupportTickets\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "status"=> $this->status,
            "priority"=> $this->priority,
            "message"=> $this->message,
            "subject"=> $this->subject,
            "note"=> $this->note,
            "user_name" => $this->user->name,
            "email" => $this->user->email,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
