<?php


namespace App\Services;


use App\Project;
use App\ProjectsClient;
use App\ProjectsStatus;
use App\ProjectsType;
use App\ProjectsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsServices
{
    public function insertProjectsType($data)
    {
        return ProjectsType::create([
            'name' => $data['name']
        ]);
    }

    public function editProjectsType($data)
    {
        $ProjectType = ProjectsType::find($data['id']);
        $ProjectType->name = $data['name'];
        $ProjectType->update();

        return $ProjectType;
    }

    public function getProjectsTypes()
    {
        return DB::connection('client')
            ->table('public.projects_types')
            ->get();
    }

    public function insertProjectsStatus($data)
    {
        return ProjectsStatus::create([
            'name' => $data['name'],
            'label' => $data['label']
        ]);
    }

    public function editProjectsStatus($data)
    {
        $ProjectsStatus = ProjectsStatus::find($data['id']);
        $ProjectsStatus->name = $data['name'];
        $ProjectsStatus->label = $data['label'];
        $ProjectsStatus->update();

        return $ProjectsStatus;
    }

    public function getProjectsStatuses()
    {
        return DB::connection('client')
            ->table('public.projects_statuses')
            ->get();
    }

    public function storeProject($data){

        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'project_status_id' => $data['project_status_id'],
            'created_by_id' => Auth::id(),
            'start_date' =>$data['start_date'],
            'end_date' => $data['end_date'],
            'project_type_id' => $data['project_type_id'],
            'status' => true
        ]);

        foreach ($data['customers'] as $customer){
            ProjectsClient::create([
                'client_id' => $customer,
                'project_id' => $project->id
            ]);
        }

        foreach ($data['assigned_to'] as $assigned_to){
            ProjectsUser::create([
                'user_id' => $assigned_to,
                'project_id' => $project->id
            ]);
        }

        return $project;

    }

    public function editProject($data){

        $project = Project::find($data['id']);
        $project->title = $data['title'];
        $project->description = $data['description'];
        $project->project_status_id = $data['project_status_id'];
        $project->start_date =$data['start_date'];
        $project->end_date = $data['end_date'];
        $project->project_type_id = $data['project_type_id'];
        $project->update();

        DB::connection('client')->table('projects_client')->where('project_id', $data['id'])->delete();

        foreach ($data['customers'] as $customer){
            ProjectsClient::create([
                'client_id' => $customer,
                'project_id' => $project->id
            ]);
        }

        DB::connection('client')->table('projects_user')->where('project_id', $data['id'])->delete();

        foreach ($data['assigned_to'] as $assigned_to){
            ProjectsUser::create([
                'user_id' => $assigned_to,
                'project_id' => $project->id
            ]);
        }

        return $project;

    }

    public function deleteProject($data){

        $project = Project::find($data['id']);
        $project->status = false;
        $project->update();

        return $project;

    }

    public function getProjects($search, $filter, $size){

        $projects = DB::connection('client')
            ->table('public.projects')
            ->where('status', true);

        if($search)
            $projects->where('title', 'like', '%' . $search . '%');


        return $projects->paginate($size);

    }
}
