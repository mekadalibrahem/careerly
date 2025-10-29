<?php

namespace App\Models\Traits;

use App\Models\User;

trait Ownable
{
    /**
     * Check if the model is owned by the given user.
     *
     * @param \App\Models\User|int $user
     * @return bool
     */
    public function isOwnedBy(User|int $user): bool
    {
        // Get the user's ID. Accepts either a User model or an integer ID.
        $userId = is_object($user) ? $user->id : $user;

        // Compare the model's user_id with the provided user's ID.
        return $this->user_id === $userId;
    }
}
