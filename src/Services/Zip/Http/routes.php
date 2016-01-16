<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Zip\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'zip'], function()
        {
            Route::any('search/{zip}', ['as' => 'zip.search', 'uses' => 'Zip@search']);
        });
    });
});

