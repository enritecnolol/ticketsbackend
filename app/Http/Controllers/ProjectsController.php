<?php

namespace App\Http\Controllers;

use App\ProjectsStatus;
use App\ProjectsType;
use App\Services\ProjectsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    private $service;

    public function __construct(ProjectsServices $service)
    {
        $this->service = $service;
    }

    public function storeProjectsType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(ProjectsType::where('name', $request->name)->first() != null){
            return apiError(null, "Este tipo de projecto ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->insertProjectsType($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El tipo de projecto fue insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editProjectsType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'name'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(ProjectsType::where('name', $request->name)->first() != null){
            return apiError(null, "Este tipo de projecto ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->editProjectsType($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El tipo de projecto fue editado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getProjectsTypes(Request $request)
    {
        try{
            $res = $this->service->getProjectsTypes();

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeProjectsStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'label'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(ProjectsStatus::where('name', $request->name)->first() != null){
            return apiError(null, "Este estado de proyecto ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->insertProjectsStatus($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El estado de proyecto fue insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editProjectsStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'label' =>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(ProjectsStatus::where('name', $request->name)->first() != null){
            return apiError(null, "Este estado de proyecto ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->editProjectsStatus($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El estado de proyecto fue editado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getProjectsStatus(Request $request)
    {
        try{
            $res = $this->service->getProjectsStatuses();

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeProject (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'description'=> 'required',
            'project_status_id'=> 'required',
            'start_date'=> 'required',
            'end_date'=> 'required',
            'project_type_id'=> 'required',
            'customers' => 'required',
            'assigned_to' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->storeProject($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El Proyecto fue insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editProject (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'title'=> 'required',
            'description'=> 'required',
            'project_status_id'=> 'required',
            'start_date'=> 'required',
            'end_date'=> 'required',
            'project_type_id'=> 'required',
            'customers' => 'required',
            'assigned_to' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->storeProject($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El Proyecto fue editado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }
    public function deleteProject (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->deleteProject($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El Proyecto fue eliminado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getProjects(Request $request)
    {
        $search = isset($request['search']) ? $request['search']: '';
        $filter = isset($request['filter']) ? $request['filter']: '';
        $size = isset($request['size']) ? $request['size']: '';

        try{
            $res = $this->service->getProjects($search, $filter, $size);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getProjectDetail(Request $request)
    {
        $id = isset($request['id']) ? $request['id']: '';

        try{
            $res = $this->service->getProjectDetail($id);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

}
