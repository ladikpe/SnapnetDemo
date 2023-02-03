<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use PDF;
use App\Contract;


class SendContractDocument extends Notification 
{
    use Queueable;
    public $contract;
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Contract $contract)
    {
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
        
       $contract=$this->contract;
$detail=$contract->contract_details()->orderBy('created_at','desc')->first();
       $pdf = \PDF::loadView('exports.final_contract', compact('detail','contract'));
        return (new MailMessage)
                    ->view('emails.contract', ['contract' => $contract])
                     ->attachData($pdf->stream(), $contract->name.'.pdf', [
                    'mime' => 'application/pdf',
                ]);
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
