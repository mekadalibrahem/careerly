<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SendRenderCvEndNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $user_id,
        public $file_id,
        public $errors= null,
    )
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $data =  [];
        $data['message'] ="Generate CV file end";
        if($this->file_id>0){
            $data['file_id'] = $this->file_id;
            $data["link"] = route("user.files.download",[
                $this->user_id,
                $this->file_id
            ]);
        }
        if ($this->errors){
            $data['message'] = "FAILED  To Generate Cv file";
        }
        $data["errors"] = $this->errors;

        return $data;
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
