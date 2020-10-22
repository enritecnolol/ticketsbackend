<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsStatus extends Model
{
    protected $table = 'public.statuses';
    protected $connection = 'client';
}
