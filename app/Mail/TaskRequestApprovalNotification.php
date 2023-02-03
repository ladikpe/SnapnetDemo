<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskRequestApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $message;
    public $sender;
    public $name;
    public $url;
    public $title;
    public $reason;


    public function __construct($message, $sender, $name, $url, $title, $reason)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
        $this->reason = $reason;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->subject($this->title)->markdown('emails.task-request-approvals');
    }
}
