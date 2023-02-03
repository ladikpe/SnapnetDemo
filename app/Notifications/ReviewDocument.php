<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Document;

class ReviewDocument extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
      public $document;
    public function __construct(Document $document)
    {
        //
        $this->document=$document;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->subject('Review Document')
                    ->line('You are to review and approve a document '.$this->document->filename.' uploaded by '.$this->document->user->name)
                    ->action('View Document', url('/documents/reviews'))
                    ->line('Thank you for using our application!');
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
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'subject'=>'Review Document-' .$this->document->filename,
            'message'=>'You are to review and approve a document '.$this->document->filename.' uploaded by '.$this->document->user->name,
            'action'=>route('documents.showreview', ['id'=>$this->document->id]),
            'type'=>'Review'
        ]);

    }
}
