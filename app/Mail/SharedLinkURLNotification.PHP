<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SharedLinkURLNotification extends Mailable
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
    public $comment;
    public $link_url;


    public function __construct($message, $sender, $name, $url, $title, $comment, $link_url)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
        $this->comment = $comment;
        $this->link_url = $link_url;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->subject($this->title)->markdown('emails.shared-link-url');
    }
}
