<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
*/
//Route::resource('api/client-manager/clients', '\RTMatt\MonthlyService\Controllers\Resource\ClientController');
Route::group([ 'prefix' => 'api/client-manager' ], function () {
    Route::resource('clients','\RTMatt\MonthlyService\Controllers\Resource\ClientController',['only'=>['index','store','destroy']]);
    Route::resource('clients.service-plan','\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanController',['only'=>['index']]);
    Route::resource('clients.service-plan.benefits', '\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanBenefitController',['only'=>['update','store','destroy']]);

    Route::resource('service-plan','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController');
    Route::controller('service-plan/{service_plan}','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController');

    Route::resource('service-month','\RTMatt\MonthlyService\Controllers\Resource\ServiceMonthController');

    Route::resource('service-benefit','\RTMatt\MonthlyService\Controllers\Resource\BenefitController');

    Route::controller('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});






/*

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

    //Route::resource('benefits', '\RTMatt\MonthlyService\Controllers\API\ClientBenefitController');
    Route::controller('service-plan/{service_plan}',
        '\RTMatt\MonthlyService\Controllers\API\ClientServicePlanController');
    Route::controller('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});
*/
//Client Manager App Access
Route::group([ 'prefix' => 'client-manager','middleware'=>['web']], function () {
    //Show the Client Manager
    Route::controller('', '\RTMatt\MonthlyService\Controllers\ClientManagerController');
    // Resource Controller For Priotity Alerts

});


