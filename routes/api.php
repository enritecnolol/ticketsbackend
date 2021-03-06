<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['auth:api']], function() {

    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('logout', 'UserController@logout');

    /*===============================/Productos\=======================================*/
    Route::get('products/paginate', 'ProductsController@ProductsPaginate');
    /*===============================/Clientes\=======================================*/
    Route::get('clients/paginate', 'ClientsController@getClients');
    Route::get('clients/select', 'ClientsController@getClientsOfSelect');
    /*===============================\Llamadas\=======================================*/
    Route::post('call', 'CallsController@storeCalls');
    Route::get('calls', 'CallsController@getCalls');
    Route::put('call', 'CallsController@editCall');
    Route::delete('call', 'CallsController@deleteCall');
    /*===============================\Tipo de asistencia\=======================================*/
    Route::post('assistanceType', 'CallsController@storeAssistanceType');
    Route::get('call/assistanceTypes', 'CallsController@getCallAssistanceType');
    Route::get('assistanceTypes', 'CallsController@getAssistanceType');
    Route::put('assistanceType', 'CallsController@editAssistanceType');
    Route::delete('assistanceType', 'CallsController@deleteAssistanceType');
    /*===============================\Tecnicos\=======================================*/
    Route::get('technicians', 'TechniciansController@TechniciansPaginate');
    Route::get('technicians/select', 'TechniciansController@TechniciansForSelect');
    /*===============================\Estados de tickets\=======================================*/
    Route::get('statuses', 'TicketsController@getTicketsStatus');
    Route::post('status', 'TicketsController@storeTicketsStatus');
    Route::put('status', 'TicketsController@editTicketsStatus');
    Route::delete('status', 'TicketsController@deleteTicketsStatus');
    /*===============================\Tipo de tickets\=======================================*/
    Route::get('ticketsType', 'TicketsController@getTicketsType');
    Route::post('ticketType', 'TicketsController@storeTicketsType');
    Route::put('ticketType', 'TicketsController@editTicketsType');
    Route::delete('ticketType', 'TicketsController@deleteTicketsType');
    /*===============================\Origenes\=======================================*/
    Route::get('origins', 'TicketsController@getOrigins');
    Route::post('origin', 'TicketsController@storeOrigin');
    Route::put('origin', 'TicketsController@editOrigin');
    Route::delete('origin', 'TicketsController@deleteOrigin');
    /*===============================\Tickets\=======================================*/
    Route::get('tickets', 'TicketsController@getTickets');
    Route::post('ticket', 'TicketsController@storeTicket');
    Route::put('ticket', 'TicketsController@editTicket');
    Route::get('ticket/user', 'TicketsController@getTicketUser');
    Route::get('ticket/projects', 'TicketsController@getTicketProjects');
    Route::get('ticket/detail', 'TicketsController@getTicketDetail');
    Route::delete('ticket', 'TicketsController@deleteTicket');
    /*===============================\Prioridades\=======================================*/
    Route::get('priorities', 'TicketsController@getPriorities');
    Route::post('priority', 'TicketsController@storePriorities');
    Route::put('priority', 'TicketsController@editPriorities');
    Route::delete('priority', 'TicketsController@deletePriorities');
    /*===============================\Seguiminetos\=======================================*/
    Route::get('tracesEntries', 'TicketsController@getTraceEntriesOfTicket');
    Route::post('traceEntries', 'TicketsController@storeTraceEntries');
    Route::put('traceEntries', 'TicketsController@editTraceEntries');
    Route::delete('traceEntries', 'TicketsController@deleteTraceEntries');
    /*===============================\tipo de proyectoss\=======================================*/
    Route::get('projectsTypes', 'ProjectsController@getProjectsTypes');
    Route::post('projectsType', 'ProjectsController@storeProjectsType');
    Route::put('projectsType', 'ProjectsController@editProjectsType');
    /*===============================\Estados de proyectos\=======================================*/
    Route::get('projectsStatuses', 'ProjectsController@getProjectsStatus');
    Route::post('projectsStatus', 'ProjectsController@storeProjectsStatus');
    Route::put('projectsStatus', 'ProjectsController@editProjectsStatus');
    /*===============================\Proyectos\=======================================*/
    Route::get('projects', 'ProjectsController@getProjects');
    Route::get('projects/select', 'ProjectsController@getProjectsSelect');
    Route::post('project', 'ProjectsController@storeProject');
    Route::put('project', 'ProjectsController@editProject');
    Route::delete('project', 'ProjectsController@deleteProject');
    Route::get('project/detail', 'ProjectsController@getProjectDetail');
    Route::get('project/users', 'ProjectsController@getProjectUsers');
    Route::get('project/clients', 'ProjectsController@getProjectClients');
    Route::get('project/tickets/user', 'ProjectsController@getProjectsTicketsUser');
    /*===============================\Calendario\=======================================*/
    Route::get('calendarEvents', 'CalendarController@getCalendarEvents');
    Route::post('calendarEvent', 'CalendarController@storeCalendarEvents');
    Route::put('calendarEvent', 'CalendarController@editCalendarEvents');
    Route::delete('calendarEvent', 'CalendarController@deleteCalendarEvents');
    /*===============================/Company\=======================================*/
    Route::post('company', 'CompaniesController@store');
    Route::get('company', 'CompaniesController@index');
    Route::put('company', 'CompaniesController@edit');
    /*===============================\TimeSheet\=======================================*/
    Route::get('timeSheets', 'TimeSheetsController@getTimeSheets');
    Route::post('timeSheet', 'TimeSheetsController@storeTimeSheets');
    Route::put('timeSheet', 'TimeSheetsController@editTimeSheets');
    Route::delete('timeSheet', 'TimeSheetsController@deleteTimeSheets');
    /*===============================\Tickets Dashboard\=======================================*/
    Route::get('getTicketsClassified', 'TicketPanelController@getTicketsClassified');

    /*===============================/migration update\=======================================*/
    Route::post('update/database', function (){
        Artisan::call('migrate', [
            '--database' => 'client',
            '--force' => true,
            '--path' => '/database/migrations/client'
        ]);
    });
});
