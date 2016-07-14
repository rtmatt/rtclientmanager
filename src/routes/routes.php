<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/


//GET THE DASHBOARD CONTENT FOR A CLIENT (Called from within client manager)
Route::get('/api/client-manager/client-dashboard/{client_id}',function($client_id){
    $client = \RTMatt\MonthlyService\Client::find($client_id);
    return view("rtclientdashboard::components.dashboard-component",['dashboard_data'=>$client->getServiceReport(),'dashboard_id'=>$client->id,'admin_mode'=>true]);
});

//Client Manager API
// Cors middleware for allowing posting of priority alerts
Route::group([ 'prefix' => 'api', 'middleware' => ['rtapi','cors'] ], function () {
    Route::controller('client-service', '\RTMatt\MonthlyService\Controllers\ClientServicesController', [
        'getIndex' => 'client-services-summary'
    ]);

});

//Client Manager API
Route::group([ 'prefix' => 'api'], function () {
    Route::get('client-manager/clients/{client_id}/service-plan','\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController@getClientServicePlan');
    Route::resource('client-manager/clients','\RTMatt\MonthlyService\Controllers\API\ClientManagerClientController');
    Route::resource('client-manager/benefits','\RTMatt\MonthlyService\Controllers\API\ClientBenefitController');
    Route::controller('client-manager/service-plan/{service_plan}','\RTMatt\MonthlyService\Controllers\API\ClientServicePlanController');
    Route::controller('client-manager','\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});

// Resource Controller For Priotity Alerts
Route::resource('/client-manager/priority-alerts', '\RTMatt\MonthlyService\Controllers\PriorityAlertController');
//Show the Client Manager
Route::controller('client-manager','\RTMatt\MonthlyService\Controllers\ClientManagerController');
