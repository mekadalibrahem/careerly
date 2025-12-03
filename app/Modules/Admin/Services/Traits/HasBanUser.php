<?php

namespace App\Modules\Admin\Services\Traits;

use App\Models\User;
use Carbon\Carbon;

trait HasBanUser
{



    public static function banUser(User $user)
    {
        try {

            $user->ban_at = Carbon::now();
            if ($user->save()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function unbanUser(User $user)
    {
        try {

            $user->ban_at = null;
            if ($user->save()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
