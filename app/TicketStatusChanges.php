<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketStatusChanges extends Model
{
    protected $table = 'public.tickets_status_changes';
    protected $connection = 'client';
}
