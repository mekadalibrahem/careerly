<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'ban_at' => $this->ban_at,
            "isBaned" => (bool) $this->ban_at,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'title' => $this->title,
            'roles' => $this->roles->pluck('name'),
            'password' => $this->password,
            'email' => $this->email,
            'name' => $this->name,
            'id' => $this->id,
            "company" => $this->company

        ];
    }
}
