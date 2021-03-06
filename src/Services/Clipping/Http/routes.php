<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Clipping\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'clipping'], function()
            {
                Route::get('/', ['as' => 'clipping', 'uses' => 'Clipping@index']);

                Route::get('post/{id}', ['as' => 'clipping.post', 'uses' => 'Clipping@post']);
            });
        });
    });
});
