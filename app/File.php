<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'public.files';
    protected $connection = 'client';

    protected $fillable = ['name', 'type', 'ticket_id'];
}
