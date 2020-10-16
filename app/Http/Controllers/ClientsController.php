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
    public function getClients()
    {
        return apiSuccess($this->service->getClients());
    }
}
