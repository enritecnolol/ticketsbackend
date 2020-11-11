<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectsStatus extends Model
{
    protected $table = 'public.projects_statuses';
    protected $connection = 'client';

    protected $fillable = ['name', 'label'];
}
