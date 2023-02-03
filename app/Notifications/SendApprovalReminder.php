<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\SmsChannel;
use PDF;

class SendApprovalReminder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
   public function __construct(Contract $contract)
    {
        //
        $this->contract=$contract;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database',SmsChannel::class];
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
                    ->action('View Contract', url('/contracts/reviews'))
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
            'action'=>url('/contracts/reviews/'.$this->contract->id),
            'type'=>'Contract Review'
        ]);

    }
    public function toSms($notifiable)
    {
        $data = [
        "to" => $dd['phone'],
        "channel" => '0000',
        "message" => $dd['message']
    ];
    $client = new Client();
    $res = $client->post('https://v2.sling.com.ng/api/v1/send-sms',
        [
            'headers' => [
                'Authorization' => 'Bearer sling_e3unemfgfwrzlp9ildw1wf6oii79jq3i0j4trhx7t3rirgx5rszj49',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
            'form_params' => $data
        ]
    );
    }
}
