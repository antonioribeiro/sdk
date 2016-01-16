<?php

Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
    Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Files\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'files'], function()
        {
            Route::post('/', ['as' => 'files.upload', 'uses' => 'Files@upload']);
        });
    });
});

