<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function __invoke() {
        Gate::authorize('is-admin');

        $stats = [
            'total'      => Ticket::count(),
            'abertos'    => Ticket::where('status','aberto')->count(),
            'andamento'  => Ticket::where('status','em_andamento')->count(),
            'resolvidos' => Ticket::where('status','resolvido')->count(),
            // tempo médio até a primeira resposta de admin (em minutos)
            'tma_primeira_resposta_min' => round(
                Ticket::whereNotNull('first_response_at')
                    ->avg(DB::raw('TIMESTAMPDIFF(SECOND, created_at, first_response_at)'))/60, 1
            ),
        ];

        // últimos 7 dias: tickets/dia
        $series = Ticket::selectRaw('DATE(created_at) d, COUNT(*) c')
            ->where('created_at','>=',now()->subDays(7))
            ->groupBy('d')->orderBy('d')->get();

        return view('dashboard', compact('stats','series'));
    }
}
