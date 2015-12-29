<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\TwoFactor\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'login'], function()
        {
            Route::get('twofactor', ['as' => 'login.twofactor', 'uses' => 'TwoFactor@create']);

            Route::post('twofactor', ['as' => 'login.twofactor', 'uses' => 'TwoFactor@store']);
        });
    });
});
