<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskRequestNotification extends Mailable
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


    public function __construct($message, $sender, $name, $url, $title)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->subject($this->title)->markdown('emails.task-requests');
    }
}
