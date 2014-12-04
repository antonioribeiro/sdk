<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Messages\Http\Controllers'], function()
{
	Route::group(['prefix' => 'messages'], function()
	{
	    Route::get('/', ['as' => 'messages', 'uses' => 'Messages@index']);

		Route::post('/', ['as' => 'messages', 'uses' => 'Messages@store']);

		Route::post('validate', ['as' => 'messages.validate', 'uses' => 'Messages@validate']);

		Route::get('list/{folder}', ['as' => 'messages.list', 'uses' => 'Messages@messages']);

		Route::get('compose', ['as' => 'messages.compose', 'uses' => 'Messages@compose']);

	    Route::get('create', ['as' => 'messages.create', 'uses' => 'Messages@create']);

	    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'Messages@show']);

	    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'Messages@update']);
	});
});

