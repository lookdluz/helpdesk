<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;

class TicketController extends BaseController {
    public function __construct(){ $this->middleware('auth'); }

    public function index() {
        $query = Ticket::with('owner')->latest();
        if (Gate::denies('is-admin')) $query->where('user_id', auth()->id());
        return view('tickets.index', ['tickets'=>$query->paginate(10)]);
    }

    public function create(){ return view('tickets.create'); }

    public function store(Request $r) {
        $data = $r->validate([
            'subject'=>'required|string|max:255',
            'description'=>'required|string',
        ]);
        $ticket = Ticket::create($data + ['user_id'=>auth()->id()]);
        // notificar admins (exemplo simples: todos admins)
        User::where('role','admin')->each(fn($admin)=>$admin->notify(new TicketCreated($ticket)));
        return redirect()->route('tickets.show',$ticket)->with('ok','Ticket aberto!');
    }

    public function show(Ticket $ticket) {
        $this->authorizeView($ticket);
        $ticket->load(['owner','replies.author']);
        return view('tickets.show', compact('ticket'));
    }

    public function update(Request $r, Ticket $ticket) {
        Gate::authorize('is-admin');
        $ticket->update($r->validate(['status'=>'required|in:aberto,em_andamento,resolvido']));
        return back()->with('ok','Status atualizado.');
    }

    private function authorizeView(Ticket $t){
        if(auth()->user()->can('is-admin')) return;
        abort_if($t->user_id !== auth()->id(), 403);
    }
}