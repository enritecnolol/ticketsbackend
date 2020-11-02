<?php


namespace App\Services;


use App\Origin;
use App\Ticket;
use App\TicketsStatus;
use App\TicketType;
use App\TicketUser;
use App\Trace;
use App\TraceEntries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketsServices
{

    public function insertStatus($data)
    {
        $status = TicketsStatus::create([
            'name' => strtoupper($data['name']),
            'company_id' => $data['company_id']
        ]);

        return $status;
    }

    public function editStatus($data)
    {
        $status = TicketsStatus::find($data['id']);
        $status->name = $data['name'];
        $status->company_id = $data['company_id'];
        $status->update();

        return $status;
    }

    public function deleteStatus($data)
    {
        $status = TicketsStatus::find($data['id']);
        $status->status = false;
        $status->update();

        return $status;
    }

    public function getStatus()
    {
        $status = DB::connection('client')
            ->table('public.statuses')
            ->where('status', true)
            ->get();

        return $status;
    }

    public function insertTicketsType($data)
    {
        $ticketType = TicketType::create([
            'name' => strtoupper($data['name']),
            'company_id' => $data['company_id']
        ]);

        return $ticketType;
    }

    public function editTicketsType($data)
    {
        $ticketType = TicketType::find($data['id']);
        $ticketType->name = $data['name'];
        $ticketType->company_id = $data['company_id'];
        $ticketType->update();

        return $ticketType;
    }

    public function deleteTicketsType($data)
    {
        $ticketType = TicketType::find($data['id']);
        $ticketType->status = false;
        $ticketType->update();

        return $ticketType;
    }

    public function getTicketsType()
    {
        $ticketType = DB::connection('client')
            ->table('public.tickets_type')
            ->where('status', true)
            ->get();

        return $ticketType;
    }

    public function insertOrigin($data)
    {
        $origin = Origin::create([
            'name' => strtoupper($data['name']),
            'company_id' => $data['company_id'],
            'status' => true
        ]);

        return $origin;
    }

    public function editOrigin($data)
    {
        $origin = Origin::find($data['id']);
        $origin->name = $data['name'];
        $origin->company_id = $data['company_id'];
        $origin->status = $data['status'];
        $origin->update();

        return $origin;
    }

    public function deleteOrigin($data)
    {
        $origin = Origin::find($data['id']);
        $origin->status = false;
        $origin->update();

        return $origin;
    }

    public function getOrigins()
    {
        $origin = DB::connection('client')
            ->table('public.origins')
            ->where('status', true)
            ->get();

        return $origin;
    }

    public function insertTicket($data)
    {
        $ticket = Ticket::create([
            'status_id' => $data['status_id'],
            'client_id' => $data['client_id'],
            'user_id' => Auth::id(),
            'tickets_type_id' => $data['tickets_type_id'],
            'company_id' => $data['company_id'],
            'priority_id' => $data['priority_id'],
            'title' => $data['title'],
            'note' => $data['note'],
            'status' => true
        ]);

        Trace::create(['ticket_id' => $ticket->id]);

        foreach ($data['assigned_to'] as $assigned_to)
        {
            TicketUser::create([
                'user_id' => $assigned_to,
                'tickets_id' => $ticket->id
            ]);
        }

        return $ticket;
    }

    public function editTicket($data)
    {
        $ticket = Ticket::find($data['id']);
        $ticket->status_id = $data['status_id'];
        $ticket->client_id = $data['client_id'];
        $ticket->tickets_type_id = $data['tickets_type_id'];
        $ticket->company_id = $data['company_id'];
        $ticket->priority_id = $data['priority_id'];
        $ticket->title = $data['title'];
        $ticket->note = $data['note'];
        $ticket->status = $data['status'];
        $ticket->update();

        DB::connection('client')
            ->table('public.tickets_user')
            ->where('ticket_id', $data['id'])
            ->delete();

        foreach ($data['assigned_to'] as $assigned_to)
        {
            TicketUser::create([
                'user_id' => $assigned_to,
                'tickets_id' => $data['id']
            ]);
        }

        return $ticket;
    }

    public function deleteTicket($data)
    {
        $ticket = Ticket::find($data['id']);
        $ticket->status = false;
        $ticket->update();

        return $ticket;
    }

    public function getTickets($search, $size)
    {
        $tickets = DB::connection('client')
            ->table('public.tickets')
//            ->where('title', $search)
//            ->where('status', true)
//            ->paginate($size);
        ->get();

        return $tickets;
    }

    public function insertTraceEntries($data)
    {
        $trace_id = Trace::where('ticket_id', $data['ticket_id'])->first();

        $trace_entries = TraceEntries::create([
            'trace_id' => $trace_id['id'],
            'user_id' => Auth::id(),
            'comment' => $data['comment']
        ]);

        return $trace_entries;
    }

    public function editTraceEntries($data)
    {
        $trace_entries = TraceEntries::find($data['trace_entries_id']);
        $trace_entries->comment = $data['comment'];
        $trace_entries->update();

        return $trace_entries;
    }

    public function deleteTraceEntries($data)
    {
        TraceEntries::find($data['trace_entries_id'])->delete();
    }

    public function getTraceEntriesOfTicket($data)
    {
        $trace = Trace::where('ticket_id', $data['ticket_id'])->first();

        $traces = DB::connection('client')
            ->table('public.trace_entries')
            ->where('trace_id', $trace['trace_id'])
            ->get()
        ;
        return $traces;
    }
}
