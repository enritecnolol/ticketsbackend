<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $table = 'public.calendar_events';
    protected $connection = 'client';

    protected $fillable = ['title', 'start', 'end_date', 'classname', 'user_id'];
}
