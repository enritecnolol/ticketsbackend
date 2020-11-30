<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table = 'public.timesheet';
    protected $connection = 'client';

    protected $fillable = ['project_id', 'ticket_id', 'user_id', 'start_time', 'end_time', 'date', 'status'];
}
