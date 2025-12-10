<?php

namespace App\Listeners;

use App\Events\ApplicantAccepted;
use App\Modules\Works\Entities\Models\Applicant;
use App\Notifications\ApplicantAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationApplicantAccepted
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
    public function handle(ApplicantAccepted $event): void
    {
        $applicant  = Applicant::where('id', $event->applicant_id)->first();
        $work = $applicant->work;
        $user = $work->user;
        $user->notify(new ApplicantAcceptedNotification($work->id, $applicant->id));
    }
}
