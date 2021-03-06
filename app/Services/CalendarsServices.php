<?php


namespace App\Services;


use App\CalendarEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarsServices
{
    public function insertEvent($data)
    {
        $calendar = CalendarEvent::create([
            'title' => $data->title,
            'start' => $data->start,
            'end_date' => $data->end_date,
            'classname' => $data->classname,
            'user_id' => Auth::id(),
        ]);
        return $calendar;
    }
    public function editEvent($data)
    {
        $calendar = CalendarEvent::find($data['id']);
        $calendar->title = $data->title;
        $calendar->start = $data->start;
        $calendar->end_date = $data->end_date;
        $calendar->classname = $data->classname;
        $calendar->update();
        return $calendar;
    }

    public function deleteEvent($data)
    {
        $calendar = CalendarEvent::find($data['id']);
        $calendar->delete();
    }

    public function getEvents($month)
    {
        return DB::connection('client')
            ->table('public.calendar_events')
            ->where(DB::raw('EXTRACT(MONTH FROM start)'), $month)
            ->select('id', 'title', 'start', DB::raw('end_date as end'), 'classname', 'user_id')
            ->get();
    }
}
