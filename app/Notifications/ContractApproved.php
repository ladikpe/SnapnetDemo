<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\ContractReview;
use App\Stage;

class ContractApproved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
      public $stage;
      public $review;
    public function __construct(Stage $stage,ContractReview $review)
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
        ->subject('Contract Approved')
        ->line('The contract, '.$this->review->contract->name.' which you submitted for approval in the '.$this->stage->workflow->name.' has been approved at the final stage '.$this->stage->name.' by '.$this->stage->user->name)
        ->line('The contract lasted for a period of '.$this->review->created_at==$this->review->updated_at?\Carbon\Carbon::parse($this->review->created_at)->diffForHumans():\Carbon\Carbon::parse($this->review->created_at)->diffForHumans($this->review->updated_at).' in this stage of approval.')
        ->action('View Contract', url("contracts/show/".$this->review->contract->id))
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
            'subject'=>$this->review->contract->name.' -Contract Approved',
            'message'=>'You are to review and approve a contract '.$this->review->contract->name.' uploaded by '.$this->review->contract->user->name,
            'action'=>url("contracts/show/".$this->review->contract->id),
            'type'=>'Review'
        ]);

    }
}
