<?php

namespace App\Listeners;

use App\Events\CvAnalyzeProcessed;
use App\Models\User;
use App\Notifications\CvAnalyzeEnd;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCvAnlayzeNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CvAnalyzeProcessed $event): void
    {
        try {
            $user = User::where('id', $event->user_id)->first();
            $user->notify(new CvAnalyzeEnd());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
