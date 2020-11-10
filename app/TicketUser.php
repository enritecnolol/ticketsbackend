<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketUser extends Model
{
    protected $table = 'public.tickets_user';
    protected $connection = 'client';

    protected $fillable = ['user_id', 'ticket_id'];
}
