<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectsType extends Model
{
    protected $table = 'public.projects_types';
    protected $connection = 'client';

    protected $fillable = ['name'];
}
