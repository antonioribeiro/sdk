<?php

Route::group(['middleware' => 'web'], function()
{
    Route::group(['prefix' => env('ROUTE_GLOBAL_PREFIX', '')], function() {
        Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Tags\Http\Controllers'], function()
        {
            Route::group(['prefix' => 'tags'], function()
            {
                Route::get('/', ['as' => 'tags', 'uses' => 'Tags@index']);

                Route::post('/', ['as' => 'tags', 'uses' => 'Tags@post']);

                Route::post('validate', ['as' => 'tags.validate', 'uses' => 'Tags@validate']);

                Route::get('edit/{id}', ['as' => 'tags.edit', 'uses' => 'Tags@edit']);

                Route::patch('edit/{id}', ['as' => 'tags.edit', 'uses' => 'Tags@update']);

                Route::delete('delete/{id}', ['as' => 'tags.delete', 'uses' => 'Tags@delete']);
            });
        });
    });
});
