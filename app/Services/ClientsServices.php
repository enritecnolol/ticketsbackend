<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class ClientsServices
{
    public function getClients(){
        return DB::connection('client')
            ->table('public.cxc_clientes')
            ->select('cia_codigo',
                'clie_codigo',
                'clie_nombre',
                'clie_pais',
                'clie_direccion',
                'clie_ciudad',
                'clie_telefonos',
                'clie_contacto'
            )
            ->paginate(10);
    }
}
