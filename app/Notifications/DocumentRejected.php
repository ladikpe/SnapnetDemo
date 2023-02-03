<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Document;
use App\Stage;
use App\Review;

class DocumentRejected extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

      public $stage;
      public $review;
    public function __construct(Stage $stage,Review $review)
    {
        //
        $this->stage=$stage;
        $this->review=$review;
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
                    ->subject('Document Rejected')
                    ->line('The document, '.$this->review->document->filename.' which you submitted for approval in the '.$stage->workflow->name.' was rejected at '.$this->stage->name.' by '.$stage->user->name)
                    ->line('The document lasted for a period of '.$this->review->created_at==$this->review->updated_at?\Carbon\Carbon::parse($this->review->created_at)->diffForHumans():\Carbon\Carbon::parse($this->review->created_at)->diffForHumans($this->review->updated_at).' in this stage of approval.')
                    ->action('View Document',  route("documents.view",$this->document->id))
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
            'subject'=>$this->review->document->filename.' -Document Rejected',
            'message'=>'The document, '.$this->review->document->filename.' which you submitted for approval in the '.$this->stage->workflow->name.'has been rejected at the '.$this->stage->name.' by '.$this->stage->user->name,
            'action'=>route('documents.showreview', ['id'=>$this->document->id]),
            'type'=>'Review'
        ]);

    }

}
