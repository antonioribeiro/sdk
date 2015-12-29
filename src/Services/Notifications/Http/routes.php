<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Notifications\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'notifications'], function()
        {
            Route::get('/', ['as' => 'notification', 'uses' => 'Notifications@index']);
        });
    });
});

