<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class RequisitionEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    // public $receiver; 
    public $message; 
    public $sender; 
    public $name;  
    public $url; 


    public function __construct($message, $sender, $name, $url)
    {                
        $this->message = $message;
        $this->sender = $sender;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        return (new MailMessage)
                    // ->from($this->sender)
                    ->subject('PaliPro Notification')
                    ->line(' '.$this->name)
                    ->line(' '.$this->message)
                    ->action('Click here to view more', $this->url);
                    //->line('Have A Lovely Day!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
    */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
