<?php

namespace App\Http\Controllers;

use App\Services\TicketsServices;
use App\TicketsStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    private $service;

    public function __construct(TicketsServices $service)
    {
        $this->service = $service;
    }

    public function storeTicketsStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->toJson(), 400);
        }

        if(TicketsStatus::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Esta categoria ya existe", 201);
        }
        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertStatus($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Categoria insertada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }
}
