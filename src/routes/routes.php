<?php
/*
|--------------------------------------------------------------------------
| Client Manager API
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => 'api/client-manager' ], function () {
    Route::resource('clients','\RTMatt\MonthlyService\Controllers\Resource\ClientController',['only'=>['index','store','destroy']]);
    Route::get('/summary',['uses'=>'\RTMatt\MonthlyService\Controllers\Resource\ClientController@getServicesSummary','as'=>'client-services-summary']);

    Route::resource('clients.service-plan','\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanController',['only'=>['index']]);
    Route::resource('clients.service-plan.benefits', '\RTMatt\MonthlyService\Controllers\Resource\ClientServicePlanBenefitController',['only'=>['update','store','destroy']]);

    Route::resource('service-plan','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController');
    Route::controller('service-plan/{service_plan}','\RTMatt\MonthlyService\Controllers\Resource\ServicePlanController');

    Route::resource('service-month','\RTMatt\MonthlyService\Controllers\Resource\ServiceMonthController');

    Route::resource('service-benefit','\RTMatt\MonthlyService\Controllers\Resource\BenefitController');

    Route::resource('priority-alert','\RTMatt\MonthlyService\Controllers\Resource\PriorityAlertController');

    Route::controller('/', '\RTMatt\MonthlyService\Controllers\API\ClientManagerAPIController');
});

/*
|--------------------------------------------------------------------------
| Client Manager Application
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => 'client-manager','middleware'=>['web']], function () {
    Route::get('/priority-alerts','\RTMatt\MonthlyService\Controllers\Resource\PriorityAlertController@index');
    Route::controller('', '\RTMatt\MonthlyService\Controllers\ClientManagerController');
});


