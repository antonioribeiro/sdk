<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['namespace' => 'PragmaRX\Sdk\Services\Notifications\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'notifications'], function()
            {
                Route::get('/', ['as' => 'notification', 'uses' => 'Notifications@index']);
            });
        });
    });
});
