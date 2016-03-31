<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Users\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'users'], function()
            {
                Route::get('/', ['as' => 'users.index', 'uses' => 'Users@index']);
            });
        });
    });
});
