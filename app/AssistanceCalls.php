<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssistanceCalls extends Model
{
    protected $table = 'public.assistance_calls';
    protected $connection = 'client';

    protected $fillable = ['call_id', 'assistance_type_id'];
}
