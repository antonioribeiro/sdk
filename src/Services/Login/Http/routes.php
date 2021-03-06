<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['namespace' => 'PragmaRX\Sdk\Services\Login\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'auth'], function()
            {
                Route::group(['before' => 'guest', 'prefix' => 'login'], function()
                {
                    Route::get('/', ['as' => 'auth.login', 'uses' => 'Login@create']);

                    Route::post('/', ['as' => 'auth.login', 'uses' => 'Login@store']);

                    Route::get('fast/{username}/{password}', ['as' => 'auth.login.fast', 'uses' => 'Login@fast']);
                });

                Route::group(['middleware' => 'auth', 'prefix' => 'logout'], function()
                {
                    Route::get('/', ['as' => 'auth.logout', 'uses' => 'Login@destroy']);
                });
            });
        });
    });
});
