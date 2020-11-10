<?php

namespace App\Http\Controllers;

use App\Origin;
use App\Priority;
use App\Services\TicketsServices;
use App\TicketsStatus;
use App\TicketType;
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
            return response()->json($validator->getMessageBag(), 400);
        }

        if(TicketsStatus::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Estado de ticket ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertStatus($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Estado de ticket insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editTicketsStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(TicketsStatus::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Esta categoria ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editStatus($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Estado de ticket editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteTicketsStatus (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteStatus($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Estado de ticket Eliminada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getTicketsStatus (Request $request)
    {

        try{
            $res = $this->service->getStatus();

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeTicketsType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(TicketType::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "El tipo de ticket ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertTicketsType($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Tipo de ticket insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editTicketsType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(TicketType::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "El tipo de ticket ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editTicketsType($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "El tipo de ticket editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteTicketsType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteTicketsType($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "El tipo de ticket Eliminada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getTicketsType (Request $request)
    {
        $search = isset($request['search']) ? $request['search']: '';

        try{
            $res = $this->service->getTicketsType($search);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeOrigin (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(Origin::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Origen ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertOrigin($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Origen insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editOrigin (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(Origin::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Origen ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editOrigin($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Origen editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteOrigin (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteOrigin($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Origen Eliminada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getOrigins (Request $request)
    {

        try{
            $res = $this->service->getOrigins();

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeTicket (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_id'=> 'required',
            'client_id'=> 'required',
            'tickets_type_id'=> 'required',
            'company_id'=> 'required',
            'priority_id'=> 'required',
            'title'=> 'required',
            'note'=> 'required',
            'assigned_to'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertTicket($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Ticket insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editTicket (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required',
            'status_id'=> 'required',
            'client_id'=> 'required',
            'tickets_type_id'=> 'required',
            'priority_id'=> 'required',
            'title'=> 'required',
            'note'=> 'required',
            'assigned_to'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editTicket($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Ticket editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteTicket (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteTicket($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Ticket Eliminada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getTickets (Request $request)
    {
        $size = isset($request['size']) ? $request['size']: '10';
        $search = isset($request['search']) ? $request['search']: '';

        try{
            $res = $this->service->getTickets($search, $size);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storeTraceEntries (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id'=> 'required',
            'comment'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertTraceEntries($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Seguimiento insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editTraceEntries (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trace_entries_id'=> 'required',
            'comment'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editTraceEntries($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Seguimiento editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deleteTraceEntries (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trace_entries_id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deleteTraceEntries($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Seguimiento eliminado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getTraceEntriesOfTicket (Request $request)
    {

        try{
            $res = $this->service->getTraceEntriesOfTicket($request['ticket_id']);

            if(!empty($res) && !is_null($res)){
                return apiSuccess($res);
            }else{
                return apiSuccess(null, "No hay data disponible");
            }

        }catch (\Exception $e){
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function storePriorities (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(Priority::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Prioridad ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->insertPriorities($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Prioridad insertado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function editPriorities (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        if(Priority::where('name', strtoupper($request->name))->first() != null){
            return apiError(null, "Prioridad ya existe", 201);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->editPriorities($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Prioridad editado correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function deletePriorities (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag(), 400);
        }

        DB::connection('client')->beginTransaction();
        try{

            $this->service->deletePriorities($request);
            DB::connection('client')->commit();
            return apiSuccess(null, "Prioridad Eliminada correctamente");

        }catch (\Exception $e){

            DB::connection('client')->rollBack();
            return apiError(null, $e->getMessage(), $e->getCode());
        }
    }

    public function getPriorities (Request $request)
    {

        try{
            $res = $this->service->getPriorities();

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
