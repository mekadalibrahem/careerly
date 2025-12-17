<?php

namespace App\Modules\Admin\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email'=> $this->email,
            'roles' => $this->roles->pluck(["name" ]),
            'title'=> $this->title,
            "ban_at"=>$this->ban_at,
            "isBaned" => (bool) $this->ban_at,
            "phone"=> $this->phone,
            "bio" => $this->bio,
            "created_at"=> $this->created_at,
            'updated_at' => $this->updated_at,
            "deleted_at"=> $this->deleted_at,
            'isDeleted' =>(bool) $this->deleted_at
        ];
    }
}
