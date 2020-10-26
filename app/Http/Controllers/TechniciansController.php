<?php

namespace App\Http\Controllers;

use App\Services\TechniciansServices;
use Illuminate\Http\Request;

class TechniciansController extends Controller
{
    private $service;

    public function __construct(TechniciansServices $service)
    {
        $this->service = $service;
    }

    public function TechniciansPaginate(Request $request)
    {
        $size = isset($request['size']) ? $request['size']: '10';
        $search = isset($request['search']) ? $request['search']: '';


        try{
            $res = $this->service->getTechniciansPaginate($size, $search);

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
