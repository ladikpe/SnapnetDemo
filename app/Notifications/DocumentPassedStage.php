<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Review;
use App\Stage;

class DocumentPassedStage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
      public $review;
      public $stage;
      public $nextstage;
    public function __construct(Review $review,Stage $stage,Stage $nextstage)
    {
        //
        $this->review=$review;
        $this->stage=$stage;
        $this->nextstage=$nextstage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail' ,'database'];
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
        ->subject('Document Passed an Approval Stage')
        ->line('The document, '.$this->review->document->filename.' which you submitted for approval in the '.$this->stage->workflow->name.'has been approved at the '.$this->stage->name.' by '.$this->stage->user->name)
        ->line('The document lasted for a period of '.$this->review->created_at==$this->review->updated_at?\Carbon\Carbon::parse($this->review->created_at)->diffForHumans():\Carbon\Carbon::parse($this->review->created_at)->diffForHumans($this->review->updated_at).' in this stage of approval.')
        ->line('The document has been moved to the'.$this->nextstage->name.'and is to be appoved by'.$this->nextstage->user->name)
        ->action('View Document',  route("documents.view",$this->review->document->id))
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
            'subject'=>$this->review->document->filename.' -Document Passed an Approval Stage',
            'message'=>'The document, '.$this->review->document->filename.' which you submitted for approval in the '.$this->stage->workflow->name.'has been approved at the '.$this->stage->name.' by '.$this->stage->user->name,
            'action'=>route('documents.showreview', ['id'=>$this->review->document->id]),
            'type'=>'Review'
        ]);

    }
}
