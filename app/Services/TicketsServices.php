<?php


namespace App\Services;


use App\Origin;
use App\Priority;
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
            'company_id' => $data['company_id'],
            'status' => true
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

    public function getTicketsType($search)
    {
        $ticketType = DB::connection('client')
            ->table('public.tickets_type')
            ->where('status', true);

        if($search)
        {
            $ticketType->where('name', 'like', '%' . $search . '%');
        }

        return $ticketType->get();
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
            'company_id' => '0001',
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
                'ticket_id' => $ticket->id
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
                'ticket_id' => $data['id']
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
            ->table(DB::raw('public.tickets as ticket'))
            ->where('ticket.status', true)
            ->join(DB::raw('public.priorities as p'),'ticket.priority_id','=','p.id');

        if($search)
        {
            $tickets->where('title', 'like', '%' . $search . '%');
        }

        $tickets->select('ticket.*', 'p.name as priority_name', 'p.color as priority_color');

        return $tickets->paginate($size);
    }

    public function getTicketDetail($id)
    {
        $tickets = Ticket::find($id);

        $tickets->assigned_to = DB::connection('client')
            ->table(DB::raw('public.tickets_user as tu'))
            ->select('tu.user_id', 'ne.emp_nom')
            ->where('ticket_id', $id)
            ->join(DB::raw('public.nom_empleado as ne'), 'tu.user_id', '=', 'ne.emp_cod')
            ->get();

        $trace_id = Trace::where('ticket_id', $id)->first();
return $trace_id;
        $tickets->trace_entries = TraceEntries::where('trace_id', $trace_id['id']);

        $tickets->client_info = DB::connection('client')
            ->table('public.cxc_clientes')
            ->select('clie_nombre', 'clie_telefonos','clie_contacto', 'clie_direccion', 'clie_ciudad')
            ->where('clie_codigo', $tickets->client_id)->first();

        $tickets->status_info = TicketsStatus::find($tickets->status_id);
        $tickets->tickets_type_info = TicketType::find($tickets->tickets_type_id);
        $tickets->priority_info = Priority::find($tickets->priority_id);

        return $tickets;
    }

    public function getTicketUsers($ticket_id)
    {
        $tickets = DB::connection('client')
            ->table('public.tickets_user')
            ->where('ticket_id', $ticket_id);

        return $tickets->get();
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

    public function insertPriorities($data)
    {
        return Priority::create([
            'name' => strtoupper($data['name']),
            'color' => $data['color'],
            'status' => true
        ]);
    }

    public function editPriorities($data)
    {
        $priority = Priority::find($data['id']);
        $priority->name = $data['name'];
        $priority->color = $data['color'];
        $priority->update();

        return $priority;
    }

    public function deletePriorities($data)
    {
        $priority = Priority::find($data['id']);
        $priority->status = false;
        $priority->update();

        return $priority;
    }

    public function getPriorities()
    {
        $priorities = DB::connection('client')
            ->table('public.priorities')
            ->where('status', true);

        return $priorities->get();
    }
}
