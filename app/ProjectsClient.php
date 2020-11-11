<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectsClient extends Model
{
    protected $table = 'public.projects_client';
    protected $connection = 'client';

    protected $fillable = ['client_id', 'project_id'];
}
