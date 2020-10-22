<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $table = 'public.calls';
    protected $connection = 'client';
}
