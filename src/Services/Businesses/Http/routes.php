<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => config('env.ROUTE_GLOBAL_PREFIX')], function() {
        Route::group(['prefix' => 'businesses', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Businesses\Http\Controllers'], function ()
        {
            Route::group(['prefix' => 'enterprises'], function ()
            {
                Route::get('/', ['as' => 'businesses.enterprises.index', 'uses' => 'Businesses@index']);

                Route::get('edit/{id}', ['as' => 'businesses.enterprises.edit', 'uses' => 'Businesses@edit']);

                Route::get('delete/{id}', ['as' => 'businesses.enterprises.delete', 'uses' => 'Businesses@delete']);

                Route::get('create', ['as' => 'businesses.enterprises.create', 'uses' => 'Businesses@create']);

                Route::post('store', ['as' => 'businesses.enterprises.store', 'uses' => 'Businesses@store']);

                Route::post('update', ['as' => 'businesses.enterprises.update', 'uses' => 'Businesses@update']);

                Route::get('select/{businessId}', ['as' => 'businesses.enterprises.select', 'uses' => 'Businesses@select']);

                Route::get('select/client/{clientId}', ['as' => 'businesses.enterprises.select.client', 'uses' => 'Businesses@selectClient']);
            });

            Route::group(['prefix' => '{businessId}/clients'], function ()
            {
                Route::get('{id}/edit', ['as' => 'businesses.clients.edit', 'uses' => 'Clients@edit']);

                Route::get('{id}/delete', ['as' => 'businesses.clients.delete', 'uses' => 'Clients@delete']);

                Route::get('{id}/telegram/setwebhook', ['as' => 'businesses.clients.telegram.setwebhook', 'uses' => 'Telegram@setWebhook']);

                Route::get('create', ['as' => 'businesses.clients.create', 'uses' => 'Clients@create']);

                Route::post('store', ['as' => 'businesses.clients.store', 'uses' => 'Clients@store']);

                Route::post('update', ['as' => 'businesses.clients.update', 'uses' => 'Clients@update']);
            });

            Route::group(['prefix' => 'client/users'], function ()
            {
                Route::get('/', ['as' => 'businesses.users.index', 'uses' => 'Users@index']);

                Route::get('edit/{id}', ['as' => 'businesses.users.edit', 'uses' => 'Users@edit']);

                Route::get('delete/{id}', ['as' => 'businesses.users.delete', 'uses' => 'Users@delete']);

                Route::get('create', ['as' => 'businesses.users.create', 'uses' => 'Users@create']);

                Route::post('store', ['as' => 'businesses.users.store', 'uses' => 'Users@store']);

                Route::post('update', ['as' => 'businesses.users.update', 'uses' => 'Users@update']);
            });
        });
    });
});


