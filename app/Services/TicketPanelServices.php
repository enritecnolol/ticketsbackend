<?php


namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketPanelServices
{
    public function getTicketsClassified()
    {


        $allStatus = [
            "pending" => [],
            "in_process" => [],
            "reviews" => [],
            "reviewed" => [],
            "finished" => []
        ];
        $status_idCounter = 1;

        foreach ($allStatus as $key => $value)
        {
            $ticketStatus = DB::connection('client')
                ->table('public.tickets as ticket')
                ->join(DB::raw('public.priorities as p'),'ticket.priority_id','=','p.id')
                ->join(DB::raw('public.cxc_clientes as cc'),'cc.clie_codigo','=','ticket.client_id')
                ->where('ticket.status', true)
                ->where('ticket.user_id', Auth::id())
                ->where('ticket.status_id', '=', $status_idCounter)
                ->select('ticket.*', 'p.name as priority_name', 'cc.clie_nombre as clie_nombre');

            $ticketStatusTicketUser = DB::connection('client')
                ->table('public.tickets_user as tu')
                ->join(DB::raw('public.tickets as ticket'),'tu.ticket_id','=','ticket.id')
                ->join(DB::raw('public.priorities as p'),'ticket.priority_id','=','p.id')
                ->join(DB::raw('public.cxc_clientes as cc'),'cc.clie_codigo','=','ticket.client_id')
                ->where('ticket.status', true)
                ->where('tu.user_id', Auth::id())
                ->where('ticket.status_id', '=',$status_idCounter)
                ->select('ticket.*', 'p.name as priority_name', 'cc.clie_nombre as clie_nombre')->unionAll($ticketStatus);

            $allStatus[$key] = $ticketStatusTicketUser->get();
            $status_idCounter++;
        }

        return $allStatus;

    }
}
