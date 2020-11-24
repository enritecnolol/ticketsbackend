<?php

namespace App\Http\Controllers;

use App\Services\CalendarsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
    private $service;

    public function __construct(CalendarsServices $service)
    {
        $this->service = $service;
    }

    public function storeCalendarEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'start'=> 'required',
            'end_date'=> 'required',
            'classname'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $res = $this->service->insertEvent($request);
            DB::connection('client')->commit();

            return apiSuccess($res, "El evento ha insertada correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editCalendarEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'title'=> 'required',
            'start'=> 'required',
            'end_date'=> 'required',
            'classname'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editEvent($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "El evento ha editado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteCalendarEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteEvent($request);
            DB::connection('client')->commit();

            return apiSuccess(null, "El evento ha sido eliminado correctamente");

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getCalendarEvents(Request $request)
    {
        $month = isset($request['month']) ? $request['month']: '';

        try{
            $res = $this->service->getEvents($month);

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
