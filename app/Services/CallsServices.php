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
        $call = Call::create([
            'client_id' => $data['client_id'],
            'date' => $data['date'],
            'sender' => $data['sender'],
            'phone_number' => $data['phone_number'],
            'motive' => $data['motive'],
            'solution' => $data['solution'],
            'duration' => $data['duration'],
            'status' => true,
            'user_id' => Auth::id(),
        ]);

        foreach ($data['assistance_types'] as $assistance_type_id)
        {
            AssistanceCalls::create([
                'call_id' => $call->id,
                'assistance_type_id' => $assistance_type_id
            ]);
        }

        return $call;
    }

    public function editCall($data)
    {
        $call = Call::find($data['id']);

        $call->client_id = $data['client_id'];
        $call->date = $data['date'];
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
                'call_id' => $data['id'],
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

    public function getCalls($size, $search)
    {
        $calls = DB::connection('client')
            ->table('public.calls')
            ->where('status', true)
            ->paginate($size);

        return $calls;
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

    public function getAssistanceType()
    {
        $assistanceType = DB::connection('client')
            ->table('public.assistance_type')
            ->where('status', true)
            ->get();

        return $assistanceType;
    }
}
