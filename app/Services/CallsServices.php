<?php


namespace App\Services;


use App\AssistanceCalls;
use App\AssistanceType;
use App\Call;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallsServices
{
    public function insertCall($data)
    {
        $call = new Call();
        $call->client_id = $data['client_id']['clie_codigo'];
        $call->user_id = Auth::id();
        $call->company_id = '0001';
        $fechaDate = $data['date'];
        $fechaTime = $data['time'];
        $fecha = date('Y-m-d H:i:s', strtotime("$fechaDate $fechaTime"));
        $call->date = $fecha;
        $call->sender = $data['sender'];
        $call->phone_number = $data['phone_number'];
        $call->motive = $data['motive'];
        $call->solution = $data['solution'];
        $call->duration = $data['duration'];
        $call->status = true;
        $call->save();

        foreach ($data['assistance_types'] as $assistance_type_id)
        {
            $assistance_call = new AssistanceCalls();
            $assistance_call->call_id = $call->id;
            $assistance_call->assistance_type_id = $assistance_type_id;
            $assistance_call->save();

        }

        return $call;
    }

    public function editCall($data)
    {
        $call = Call::find($data['id']);

        $call->client_id = $data['client_id']['clie_codigo'];
        $fechaDate = $data['date'];
        $fechaTime = $data['time'];
        $fecha = date('Y-m-d H:i:s', strtotime("$fechaDate $fechaTime"));
        $call->date = $fecha;
        $call->sender = $data['sender'];
        $call->phone_number = $data['phone_number'];
        $call->motive = $data['motive'];
        $call->solution = $data['solution'];
        $call->duration = $data['duration'];
        $call->update();

        DB::connection('client')
            ->table('public.assistance_calls')
            ->where('call_id', $data['id'])
            ->delete();

        foreach ($data['assistance_types'] as $assistance_type_id)
        {
            AssistanceCalls::create([
                'call_id' => $call->id,
                'assistance_type_id' => $assistance_type_id
            ]);
        }

        return $call;
    }

    public function deleteCall($data)
    {
        $call = Call::find($data['id']);
        $call->status = false;
        $call->update();

        return $call;
    }

    public function getCalls($size, $search, $filters)
    {
        $calls = DB::connection('client')
            ->table(DB::raw('public.calls call'))
            ->join(DB::raw('public.cxc_clientes client'), 'call.client_id', '=', 'client.clie_codigo')
            ->where('call.status', true)
            ->select('call.*', 'client.clie_nombre');

//        if($filters['date'])
//        {
//            $calls->whereBetween('call.date', [$filters['date']['date_from'] ,$filters['date']['date_to']]);
//        }
//
//        if($filters['client'])
//        {
//            $calls->where('call.client_id', $filters['client']);
//        }


        return $calls->paginate($size);
    }
    #=============================\Assistance Type\================================================================
    public function insertAssistanceType($data)
    {
        $assistanceType = AssistanceType::create([
            'name' => $data['name'],
            'status' => true,
        ]);

        return $assistanceType;
    }

    public function editAssistanceType($data)
    {
        $assistanceType = AssistanceType::find($data['id']);
        $assistanceType->name = $data['name'];
        $assistanceType->update();

        return $assistanceType;
    }

    public function deleteAssistanceType($data)
    {
        $assistanceType = AssistanceType::find($data['id']);
        $assistanceType->status = false;
        $assistanceType->update();

        return $assistanceType;
    }

    public function getAssistanceType($search)
    {
        $assistanceType = DB::connection('client')
            ->table('public.assistance_type')
            ->where('status', true);

        if($search)
        {
            $assistanceType->where('name', 'like', '%' . $search . '%');
        }

        return $assistanceType->get();
    }

    public function getCallAssistanceType($call_id)
    {
        $assistance_calls = DB::connection('client')
            ->table('public.assistance_calls')
            ->where('call_id', $call_id)
            ->select('assistance_type_id')
        ;

        return $assistance_calls->get();
    }
}
