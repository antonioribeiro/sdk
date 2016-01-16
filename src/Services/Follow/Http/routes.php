<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
    Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Follow\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'follow'], function()
        {
            Route::get('{username}', ['as' => 'follow', 'uses' => 'Follow@store']);
        });

        Route::group(['prefix' => 'unfollow'], function()
        {
            Route::get('{username}', ['as' => 'unfollow', 'uses' => 'Follow@destroy']);
        });
    });
});

