<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketReplied extends Notification implements ShouldQueue {
    use Queueable;
    public function __construct(public Ticket $ticket, public TicketReply $reply) {}
    public function via($notifiable){ return ['mail']; }
    public function toMail($notifiable){
        return (new MailMessage)
            ->subject('Seu ticket recebeu uma resposta')
            ->line(Str::limit(strip_tags($this->reply->message),120))
            ->action('Ver Ticket', url(route('tickets.show',$this->ticket)));
    }
}