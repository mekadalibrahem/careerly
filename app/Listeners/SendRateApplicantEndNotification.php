<?php

namespace App\Listeners;

use App\Events\RateApplicantProcessed;
use App\Models\User;
use App\Modules\Works\Entities\Models\Work;
use App\Notifications\RateApplicantEnd;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use InvalidArgumentException;

class SendRateApplicantEndNotification
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
    public function handle(RateApplicantProcessed $event): void
    {
        try {
            $work = Work::where('id', $event->work_id)->with('user')->first();
            if (!$work) {
                throw new InvalidArgumentException();
            }
            $user = $work->user;
            $user->notify(new RateApplicantEnd($work->id, $event->message));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
