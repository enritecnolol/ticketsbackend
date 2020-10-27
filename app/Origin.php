<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $table = 'public.origin';
    protected $connection = 'client';

    protected $fillable = ['name', 'company_id', 'status'];
}
