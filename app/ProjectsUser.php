<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectsUser extends Model
{
    protected $table = 'public.projects_user';
    protected $connection = 'client';

    protected $fillable = ['project_id', 'user_id'];
}
