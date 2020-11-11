<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'public.projects';
    protected $connection = 'client';

    protected $fillable = ['title', 'description', 'project_status_id', 'created_by_id', 'start_date', 'end_date', 'project_type_id', 'status'];
}
