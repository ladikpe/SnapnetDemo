<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Contract;
use App\ContractReview;


class ReviewContract extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
      public $contract;
      public $contract_review;
    public function __construct(Contract $contract,ContractReview $contract_review)
    {
        //
        $this->contract=$contract;
        $this->contract_review=$contract_review;
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
                    ->subject('Review Contract')
                    ->line('You are to review and approve a contract '.$this->contract->name)
                    ->action('View Contract', url('/approve_contract/'.$this->contract_review->id))
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
            'subject'=>'Review Contract-' .$this->contract->name,
            'message'=>'You are to review and approve a contract '.$this->contract->name,
            'action'=>url('/approve_contract/'.$this->contract->id),
            'type'=>'Contract Review'
        ]);

    }
}
