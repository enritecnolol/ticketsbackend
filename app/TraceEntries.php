<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraceEntries extends Model
{
    protected $table = 'public.trace_entries';
    protected $connection = 'client';

    protected $fillable = ['trace_id', 'user_id', 'comment'];
}
