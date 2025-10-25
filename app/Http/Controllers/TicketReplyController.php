<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketReplied;

class TicketReplyController extends Controller {
    public function store(Request $r, Ticket $ticket) {
        $r->validate(['message'=>'required|string', 'attachment'=>'nullable|file|max:5120']);
        $path = $r->file('attachment')?->store('attachments','public');

        $reply = $ticket->replies()->create([
            'user_id'=>auth()->id(),
            'message'=>$r->message,
            'attachment_path'=>$path
        ]);

        // marca first_response_at se for a primeira resposta de admin
        if (auth()->user()->role === 'admin' && is_null($ticket->first_response_at)) {
            $ticket->update(['first_response_at'=>now(), 'status'=>'em_andamento']);
        }

        // notifica o dono se a resposta for de admin; senão, notifica admins
        if (auth()->user()->role === 'admin') {
            $ticket->owner->notify(new TicketReplied($ticket, $reply));
        } else {
            User::where('role','admin')->each(fn($a)=>$a->notify(new TicketReplied($ticket, $reply)));
        }

        return back()->with('ok','Resposta enviada.');
    }
}
