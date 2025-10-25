<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification implements ShouldQueue {
    use Queueable;
    public function __construct(public Ticket $ticket) {}
    public function via($notifiable){ return ['mail']; }
    public function toMail($notifiable){
        return (new MailMessage)
            ->subject('Novo ticket aberto')
            ->line('Assunto: '.$this->ticket->subject)
            ->action('Ver Ticket', url(route('tickets.show',$this->ticket)));
    }
}