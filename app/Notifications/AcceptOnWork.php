<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptOnWork extends Notification
{
    use Queueable;
    public $work_id;
    public $work_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($work_id, $work_name)
    {
        $this->work_id = $work_id;
        $this->work_name = $work_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.accept-on-work');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toDatabase(object $notifiable)
    {
        return  [
            "message" => "You are accept on work",
            "work_id" => $this->work_id,
            "work_name" => $this->work_name,
        ];
    }
}
