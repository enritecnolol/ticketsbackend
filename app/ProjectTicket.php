<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTicket extends Model
{
    protected $table = 'public.project_tickets';
    protected $connection = 'client';

    protected $fillable = ['project_id', 'ticket_id'];
}
