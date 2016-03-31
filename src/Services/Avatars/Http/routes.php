<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Avatars\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'files'], function()
            {
                Route::post('/', ['as' => 'files.upload', 'uses' => 'Avatars@upload']);
            });
        });
    });
});
