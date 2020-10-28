<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'public.tickets';
    protected $connection = 'client';

    protected $fillable = ['status_id', 'client_id', 'user_id', 'tickets_type_id', 'company_id', 'priority_id', 'title', 'note', 'status'];
}
