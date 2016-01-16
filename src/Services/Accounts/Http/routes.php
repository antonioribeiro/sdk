<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Accounts\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'account'], function()
        {
            Route::get('activate/{email}/{token}', ['as' => 'account.activate', 'uses' => 'Accounts@activate']);
        });
    });
});
