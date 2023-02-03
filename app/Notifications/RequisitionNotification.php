<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\PurchaseOrderRequisition;
use App\PurchaseOrder;
use PDF;

class RequisitionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $requisition;

    public function __construct(PurchaseOrderRequisition $requisition)
    {
        //
        $this->requisition=$requisition;
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
            ->subject('Purchase Order Requisition')
            ->line('You have a requisition request from '.$this->requisition->assign->name.' to create a purchase order with the subject '.$this->requisition->name)
            ->action('Create Purchase Order', url('localhost:4000//purchase-order-create/'.$this->requisition->id))
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
            'subject'=>'Create Purchase Order-' .$this->requisition->name,
            'message'=>'You have a requisition request from '.$this->requisition->assign->name.' to create a contract with the subject '.$this->requisition->name,
            'action'=>'Create Purchase Order', url('localhost:4000/purchase-order-create/'.$this->requisition->id),
            'type'=>'Create Purchase Order'
        ]);

    }
}

