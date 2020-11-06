<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class ClientsServices
{
    public function getClients($size, $search){
        $clients =  DB::connection('client')
            ->table('public.cxc_clientes')
            ->select('cia_codigo',
                'clie_codigo',
                'clie_nombre',
                'clie_pais',
                'clie_direccion',
                'clie_ciudad',
                'clie_telefonos',
                'clie_contacto'
            );

        if($search)
        {
            $clients->where('clie_codigo', $search)
                ->orWhere('clie_nombre', 'like', '%' . $search . '%');
        }

        return $clients->paginate($size);
    }
    public function getClientsOfSelect(){

        return DB::connection('client')
            ->table('public.cxc_clientes')
            ->select('cia_codigo', 'clie_codigo', 'clie_nombre')
            ->get();

    }
}
