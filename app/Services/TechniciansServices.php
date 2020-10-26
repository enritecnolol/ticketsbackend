<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class TechniciansServices
{
    public function getTechniciansPaginate($size, $search)
    {
        $technicians = DB::connection('client')
            ->table('public.nom_empleado')
            ->select('cia_codigo',
                'emp_cod',
                'emp_apellidos',
                'emp_nombres',
                'emp_nom',
                'emp_dir',
                'emp_ciu',
                'emp_ced',
                'emp_fechan',
                'emp_cargo',
                'emp_tel'
            )
            ->where('emp_cod', $search)
            ->orWhere('emp_nom', 'like', '%' . $search . '%')
            ->paginate($size);

        return $technicians;
    }
}
