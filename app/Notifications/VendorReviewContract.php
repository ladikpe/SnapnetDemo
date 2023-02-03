<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Contract;


class VendorReviewContract extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
      public $contract;
      public $key;
    public function __construct(Contract $contract,$key)
    {
        //
        $this->contract=$contract;
        $this->key=$key;
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
                    ->line('You are to review  a contract '.$this->contract->name)
                    ->line('To view this contract you require a One Time Password which will expire in a week. See Password Below')
                    ->line('')
                    ->line($this->key)
                    ->line('')
                    ->action('View Contract', url('/vendor_view_contract/'.\Crypt::encryptString($this->contract->id)))
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
            'message'=>'You are to review e a contract '.$this->contract->name,
            'action'=>url('/vendor_view_contract/'.$this->contract->id),
            'type'=>'Vendor Contract Review'
        ]);

    }
}
