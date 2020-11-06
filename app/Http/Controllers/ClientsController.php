<?php

namespace App\Http\Controllers;

use App\Services\ClientsServices;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    private $service;

    public function __construct(ClientsServices $service)
    {
        $this->service = $service;
    }
    public function getClients(Request $request)
    {
        $size = isset($request['size']) ? $request['size']: '10';
        $search = isset($request['search']) ? $request['search']: '';

        try{
            $res = $this->service->getClients($size, $search);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getClientsOfSelect()
    {

        try{
            $res = $this->service->getClientsOfSelect();

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
