<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskAssignmentNotification extends Mailable
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
    public $task;
    public $priority;
    public $sensitivity;


    public function __construct($message, $sender, $name, $url, $title, $task, $priority, $sensitivity)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
        $this->task = $task;
        $this->priority = $priority;
        $this->sensitivity = $sensitivity;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->subject($this->title)->markdown('emails.task-assignment');
    }
}
