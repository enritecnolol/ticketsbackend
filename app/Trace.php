<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $table = 'public.traces';
    protected $connection = 'client';
}
