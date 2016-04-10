<?php

Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() 
{
    Route::group(['namespace' => 'PragmaRX\Sdk\Services\Telegram\Http\Controllers'], function()
    {
        Route::group(['prefix' => 'telegram'], function()
        {
            Route::post('{robot}/{token}/webhook/handle', ['as' => 'telegram.webhook.handle', 'uses' => 'Telegram@handleWebhook']);
        });
    });
});
