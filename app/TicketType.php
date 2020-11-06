<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'public.tickets_type';
    protected $connection = 'client';

    protected $fillable = ['company_id', 'name', 'status'];
}
