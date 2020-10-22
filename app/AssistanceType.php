<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssistanceType extends Model
{
    protected $table = 'public.assistance_type';
    protected $connection = 'client';
}
