<?php
/*
|--------------------------------------------------------------------------
| Client Manager API
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => 'api/client-manager' ,'middleware' => 'cors'], function(){
    Route::resource('priority-alert','\RTMatt\MonthlyService\Controllers\Resource\PriorityAlertController',['only'=>['store']]);
});
Route::group([ 'prefix' => 'api/client-manager' ], function () {
    Route::resource('clients','\RTMatt\MonthlyService\Controllers\Resource\ClientController',['only'=>['index','store','destroy']]);
    Route::get('/summary',['uses'=>'\RTMatt\MonthlyService\Controllers\Resource\ClientController@getServicesSummary','as'=>'client-services-summary']);

    Route::resource('clients.service-plan','\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanController',['only'=>['index']]);
    Route::resource('clients.service-plan.benefits', '\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanBenefitController',['only'=>['update','store','destroy']]);

    Route::resource('service-plan','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController',['only'=>['update']]);
    Route::controller('service-plan/{service_plan}','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController');

    Route::resource('service-month','\RTMatt\MonthlyService\Controllers\Resource\ServiceMonthController',['only'=>['update']]);

    Route::resource('service-benefit','\RTMatt\MonthlyService\Controllers\Resource\BenefitController',['only'=>['update','store','destroy']]);

    Route::resource('priority-alert','\RTMatt\MonthlyService\Controllers\Resource\PriorityAlertController',['only'=>['index']]);

    Route::controller('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});

/*
|--------------------------------------------------------------------------
| Client Manager Application
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => config('rtclientmanager.client_manager_url'),'middleware'=>['web']], function () {
    Route::get('/priority-alerts','\RTMatt\MonthlyService\Controllers\Resource\PriorityAlertController@index');
    Route::controller('', '\RTMatt\MonthlyService\Controllers\ClientManagerController');
});


