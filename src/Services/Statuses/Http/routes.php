<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Statuses\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'statuses'], function()
        {
            Route::get('/', ['as' => 'statuses', 'uses' => 'Statuses@index']);

            Route::post('/', ['as' => 'statuses', 'uses' => 'Statuses@store']);
        });
    });
});
