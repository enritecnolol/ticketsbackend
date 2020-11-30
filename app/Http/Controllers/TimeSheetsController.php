<?php

namespace App\Http\Controllers;

use App\Services\TimesheetServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TimeSheetsController extends Controller
{
    private $service;

    public function __construct(TimesheetServices $service)
    {
        $this->service = $service;
    }

    public function storeTimeSheets (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id'=> 'required',
            'ticket_id'=> 'required',
            'start_time'=> 'required',
            'end_time'=> 'required',
            'date'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->storeTimesheet($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "TimeSheet insertado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editTimeSheets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'project_id'=> 'required',
            'ticket_id'=> 'required',
            'start_time'=> 'required',
            'end_time'=> 'required',
            'date'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editTimesheet($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "TimeSheet editado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteTimeSheets (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteTimesheet($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "TimeSheet eliminada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getTimeSheets(Request $request)
    {
        $size = isset($request['size']) ? $request['size']: '10';
        $filters = isset($request['filters']) ? json_decode($request['filters'], true) : [];

        try{
            $res = $this->service->getTimesheet(
                $size,
                isset($request['filters']) ? $filters : []
            );

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
