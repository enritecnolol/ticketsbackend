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


    /*===============================\Llamadas\=======================================*/
    Route::post('call', 'CallsController@storeCalls');
    Route::get('calls', 'CallsController@getCalls');
    Route::put('call', 'CallsController@editCall');
    Route::delete('call', 'CallsController@deleteCall');

    /*===============================\Tipo de asistencia\=======================================*/
    Route::post('assistanceType', 'CallsController@storeAssistanceType');
    Route::get('assistanceTypes', 'CallsController@getAssistanceType');
    Route::put('assistanceType', 'CallsController@editAssistanceType');
    Route::delete('assistanceType', 'CallsController@deleteAssistanceType');

    /*===============================/Company\=======================================*/
    Route::post('company', 'CompaniesController@store');
    Route::get('company', 'CompaniesController@index');
    Route::put('company', 'CompaniesController@edit');

    /*===============================/migration update\=======================================*/
    Route::post('update/database', function (){
        Artisan::call('migrate', [
            '--database' => 'client',
            '--force' => true,
            '--path' => '/database/migrations/client'
        ]);
    });
});
