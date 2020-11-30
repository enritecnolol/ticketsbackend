<?php


namespace App\Services;


use App\Timesheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetServices
{
    public function storeTimesheet($data)
    {
        return Timesheet::create([
            'project_id' => $data['project_id'],
            'ticket_id' => $data['ticket_id'],
            'user_id' => Auth::id(),
            'start_time' => date('Y-m-d H:i:s', strtotime($data['start_time'])),
            'end_time' => date('Y-m-d H:i:s', strtotime($data['end_time'])),
            'date' => date('Y-m-d', strtotime($data['date'])),
            'status' => true,
        ]);

    }

    public function editTimesheet($data)
    {
        $timesheet = Timesheet::find($data['id']);
        $timesheet->project_id = $data['project_id'];
        $timesheet->ticket_id = $data['ticket_id'];
        $timesheet->start_time = date('Y-m-d H:i:s', strtotime($data['start_time']));
        $timesheet->end_time = date('Y-m-d H:i:s', strtotime($data['end_time']));
        $timesheet->date = date('Y-m-d', strtotime($data['date']));
        $timesheet->update();

        return $timesheet;
    }

    public function deleteTimesheet($data)
    {
        $timesheet = Timesheet::find($data['id']);
        $timesheet->status = false;
        $timesheet->update();

    }

    public function getTimesheet($size, array $filters)
    {
        $timeSheets = DB::connection('client')
            ->table(DB::raw('public.timesheet as ts'))
            ->join(DB::raw('public.projects as p'),'ts.project_id','=', 'p.id')
            ->join(DB::raw('public.tickets as t'),'ts.ticket_id','=', 't.id');

        $timeSheets->select('ts.*', 'p.title as project_title', 't.title');

        if(isset($filters['date']))
            $timeSheets->whereBetween('date', [$filters['date']['date_from'], $filters['date']['date_to']]);

        if(isset($filters['project_id']))
            $timeSheets->where('project_id', $filters['project_id']);

        return $timeSheets->paginate($size);
    }

}
