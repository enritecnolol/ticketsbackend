<?php


namespace App\Services;


use App\Origin;
use App\TicketsStatus;
use App\TicketType;
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
}
