<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Language\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'language'], function()
        {
            Route::get('{lang}', ['as' => 'language', 'uses' => 'Language@change']);
        });
    });
});


