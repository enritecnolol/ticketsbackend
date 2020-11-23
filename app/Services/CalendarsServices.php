<?php


namespace App\Services;


use App\CalendarEvent;
use Illuminate\Support\Facades\DB;

class CalendarsServices
{
    public function insertEvent($data)
    {
        $calendar = CalendarEvent::create([
            'title' => $data->title,
            'start' => $data->start,
            'end' => $data->end_date,
            'classname' => $data->classname,
        ]);
        return $calendar;
    }
    public function editEvent($data)
    {
        $calendar = CalendarEvent::find($data['id']);
        $calendar->title = $data->title;
        $calendar->start = $data->start;
        $calendar->end = $data->end_date;
        $calendar->classname = $data->classname;
        $calendar->update();
        return $calendar;
    }

    public function deleteEvent($data)
    {
        $calendar = CalendarEvent::find($data['id']);
        $calendar->delete();
    }

    public function getEvents($moth)
    {
        return DB::connection('client')
            ->table('public.calendar_events')
            ->where(DB::raw('EXTRACT(MONTH FROM start)'), $moth)
            ->where(DB::raw('EXTRACT(MONTH FROM end_date)'), $moth)->get();
    }
}
