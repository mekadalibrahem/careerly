<?php

namespace App\Listeners;

use App\Events\ApplicantRejected;
use App\Models\User;
use App\Modules\Works\Entities\Models\Applicant;
use App\Notifications\ApplicantRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationApplicantRejected
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
    public function handle(ApplicantRejected $event): void
    {
        $applicant  = Applicant::where('id', $event->applicant_id)->first();
        $user = $applicant->user;
        $work = $applicant->work;
        $user->notify(new ApplicantRejectedNotification($work->id, $applicant->id));
    }
}
