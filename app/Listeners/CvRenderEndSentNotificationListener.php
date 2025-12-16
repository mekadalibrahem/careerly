<?php

namespace App\Listeners;

use App\Events\CvRenderEndEvent;
use App\Models\User;
use App\Notifications\SendRenderCvEndNotification;

class CvRenderEndSentNotificationListener
{
    public function __construct()
    {
    }

    public function handle(CvRenderEndEvent $event): void
    {
        try {
            $user = User::where("id" , $event->user_id)->first();
            $user->notify(new SendRenderCvEndNotification($event->user_id,$event->file_id,$event->errors));
        }catch (\Throwable $th){
            logger()->error("notification : " . $th->getMessage());
        }
    }
}
