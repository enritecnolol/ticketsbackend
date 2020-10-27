<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraceEntries extends Model
{
    protected $table = 'public.trace_entries';
    protected $connection = 'client';
}
