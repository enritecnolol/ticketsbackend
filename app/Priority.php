<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'public.priorities';
    protected $connection = 'client';

    protected $fillable = ['name'];
}
