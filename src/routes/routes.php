<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/

//Client Manager API
// Cors middleware for allowing posting of priority alerts
Route::group([ 'prefix' => 'api', 'middleware' => [ 'rtapi', 'cors' ] ], function () {
    Route::controller('client-service', '\RTMatt\MonthlyService\Controllers\ClientServicesController', [
        'getIndex' => 'client-services-summary'
    ]);

});

//Client Manager API
Route::group([ 'prefix' => 'api/client-manager' ], function () {
    Route::group([ 'prefix' => 'clients' ], function () {
        Route::resource('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerClientController');
        Route::get('{client_id}/service-plan',
            '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController@getClientServicePlan');
    });
    Route::resource('benefits', '\RTMatt\MonthlyService\Controllers\API\ClientBenefitController');
    Route::controller('service-plan/{service_plan}',
        '\RTMatt\MonthlyService\Controllers\API\ClientServicePlanController');
    Route::controller('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});

//Client Manager App Access
Route::group([ 'prefix' => 'client-manager','middleware'=>['web']], function () {
    //Show the Client Manager
    Route::controller('', '\RTMatt\MonthlyService\Controllers\ClientManagerController');
    // Resource Controller For Priotity Alerts
    Route::resource('priority-alerts', '\RTMatt\MonthlyService\Controllers\PriorityAlertController');
});


