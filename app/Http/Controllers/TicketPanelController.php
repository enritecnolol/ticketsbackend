<?php

namespace App\Http\Controllers;

use App\Services\TicketPanelServices;
use Illuminate\Http\Request;

class TicketPanelController extends Controller
{
    private $service;

    public function __construct(TicketPanelServices $service)
    {
        $this->service = $service;
    }

    public function getTicketsClassified (Request $request)
    {

        try{
            $res = $this->service->getTicketsClassified();

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
