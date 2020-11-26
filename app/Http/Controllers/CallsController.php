<?php

namespace App\Http\Controllers;

use App\AssistanceType;
use App\Services\CallsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CallsController extends Controller
{
    private $service;

    public function __construct(CallsServices $service)
    {
        $this->service = $service;
    }

    public function storeCalls (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id'=> 'required',
            'phone_number'=> 'required',
            'sender'=> 'required',
            'motive'=> 'required',
            'duration'=> 'required',
            'assistance_types' => 'required',
            'solution' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->insertCall($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "Llamada insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editCall(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'client_id'=> 'required',
            'phone_number'=> 'required',
            'sender'=> 'required',
            'motive'=> 'required',
            'duration'=> 'required',
            'assistance_types'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editCall($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "Llamada editada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteCall (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteCall($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "Llamada eliminada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getCalls(Request $request)
    {
        $size = isset($request['size']) ? $request['size']: '10';
        $search = isset($request['search']) ? $request['search']: '';
        $filters = isset($request['filters']) ? json_decode($request['filters'], true): '';

        try{
            $res = $this->service->getCalls($size, $search, $filters);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    #=============================|Assistance Type|===================================

    public function storeAssistanceType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(AssistanceType::where('name', $request->name)->first() != null){
            return apiError(null, "Este tipo de asistencia ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertAssistanceType($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "Tipo de asistencia insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editAssistanceType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'name'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(AssistanceType::where('name', $request->name)->first() != null){
            return apiError(null, "Este tipo de asistencia ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editAssistanceType($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "Tipo de asistencia editada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteAssistanceType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteAssistanceType($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "Tipo de asistencia eliminada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getAssistanceType(Request $request)
    {
        $search = isset($request['search']) ? $request['search']: '';

        try{
            $res = $this->service->getAssistanceType($search);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getCallAssistanceType(Request $request)
    {
        $call_id = isset($request['call_id']) ? $request['call_id']: '';

        try{
            $res = $this->service->getCallAssistanceType($call_id);

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
