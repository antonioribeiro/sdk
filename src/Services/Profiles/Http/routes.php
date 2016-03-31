<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['middleware' => 'web'], function()
    {
        Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
            Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Profiles\Http\Controllers'], function()
            {
                Route::group(['prefix' => 'profile'], function()
                {
                    Route::get('edit/{__username}', ['as' => 'profile.edit', 'uses' => 'Profiles@edit']);

                    Route::patch('edit/{__username}', ['as' => 'profile.edit', 'uses' => 'Profiles@update']);

                    Route::get('{__username?}', ['as' => 'profile', 'uses' => 'Profiles@show']);
                });
            });
        });
    });
});
