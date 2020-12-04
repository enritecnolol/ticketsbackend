<?php


namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketPanelServices
{
    public function getTicketsClassified()
    {

        $ticketStatus = DB::connection('client')
            ->table('public.tickets_user as tu')
            ->where('tu.user_id', Auth::id())
            ->where('ticket.status', true)
            ->join(DB::raw('public.tickets as ticket'),'tu.ticket_id','=','ticket.id')
            ->join(DB::raw('public.priorities as p'),'ticket.priority_id','=','p.id')
            ->join(DB::raw('public.cxc_clientes as cc'),'cc.clie_codigo','=','ticket.client_id')
            ->select('ticket.*', 'p.name as priority_name', 'cc.clie_nombre as clie_nombre');

        $pending = $ticketStatus->where('ticket.status_id', 1)
            ->get();

        $in_process = $ticketStatus->where('ticket.status_id', 2)
            ->get();

        $reviews = $ticketStatus->where('ticket.status_id', 3)
            ->get();

        $reviewed = $ticketStatus->where('ticket.status_id', 4)
            ->get();

        $finished = $ticketStatus->where('ticket.status_id', 5)
            ->get();

        return [
            "pending" => $pending,
            "in_process" => $in_process,
            "reviews" => $reviews,
            "reviewed" => $reviewed,
            "finished" => $finished
        ];

    }
}
