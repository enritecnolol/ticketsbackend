<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $table = 'public.calls';
    protected $connection = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'company_id', 'date', 'sender', 'phone_number', 'motive', 'solution', 'duration', 'status', 'user_id'];
}
