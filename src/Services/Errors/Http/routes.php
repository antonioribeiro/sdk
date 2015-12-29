<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Errors\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'error'], function()
        {
            Route::get('{code}', ['as' => 'error', 'uses' => 'Errors@raise']);
        });
    });
});

