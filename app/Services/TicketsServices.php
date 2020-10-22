<?php


namespace App\Services;


use App\TicketsStatus;

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
}
