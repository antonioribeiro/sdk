<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Settings\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'settings'], function()
        {
            Route::get('/', ['as' => 'settings', 'uses' => 'Settings@edit']);

            Route::patch('/', ['as' => 'settings', 'uses' => 'Settings@update']);
        });
    });
});



