<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\PurchaseOrder;
use PDF;

class PurchaseOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $purchase_order;

    public function __construct(PurchaseOrder $purchase_order)
    {
        //
        $this->purchase_order=$purchase_order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $purchase_order = \App\PurchaseOrder::where('id', $this->purchase_order->id)->first();
//      pdf = \PDF::loadView('exports.final_contract', compact('detail','contract'));
        return (new MailMessage)
            ->subject('Purchase Order Requisition')
            ->line('A new purchase order '.$this->purchase_order->name.' has been created by '.$this->purchase_order->author->name)
            ->action('View Purchase Order', url('http://localhost:4000//purchase-order-edit/'.$this->purchase_order->id))
            ->line('Thank you for using our application!');
    }


//        $contract=$this->contract;
//        $detail=$contract->contract_details()->orderBy('created_at','desc')->first();
//        $pdf = \PDF::loadView('exports.final_contract', compact('detail','contract'));
//        return (new MailMessage)
//        ->view('emails.contract', ['contract' => $contract])
//        ->attachData($pdf->stream(), $contract->name.'.pdf', ['mime' => 'application/pdf', ]);

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
        return new DatabaseMessage(
            [
                'subject'=>'Purchase Order Created-' .$this->purchase_order->name,
                'message'=>'A new purchase order '.$this->purchase_order->name.' has been created by '.$this->purchase_order->author->name,
                'action'=>'View Purchase Order', url('http://localhost:4000//purchase-order-edit/'.$this->purchase_order->id),
                'type'=>'View Purchase Order'
            ]);

    }
}

