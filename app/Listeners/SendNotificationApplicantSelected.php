<?php

namespace App\Listeners;

use App\Events\ApplicantSelected;
use App\Modules\Works\Entities\Models\Applicant;
use App\Notifications\ApplicantSelectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationApplicantSelected
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
    public function handle(ApplicantSelected $event): void
    {
        $applicant  = Applicant::where('id', $event->applicant_id)->first();
        $user = $applicant->user;
        $work = $applicant->work;
        $user->notify(new ApplicantSelectedNotification($work->id, $applicant->id));
    }
}
