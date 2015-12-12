<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Messages\Http\Controllers'], function()
{
	Route::group(['prefix' => 'messages/folders'], function()
	{
		Route::get('/{currentFolder?}', ['as' => 'messages.folders', 'uses' => 'Folders@index']);

		Route::post('/', ['as' => 'messages.folders', 'uses' => 'Folders@store']);

		Route::post('validate', ['as' => 'messages.folders.validate', 'uses' => 'Folders@validateData']);
	});

	Route::group(['prefix' => 'messages'], function()
	{
	    Route::get('/', ['as' => 'messages', 'uses' => 'Messages@index']);

		Route::post('/', ['as' => 'messages', 'uses' => 'Messages@store']);

		Route::post('validate', ['as' => 'messages.validate', 'uses' => 'Messages@validateData']);

		Route::get('list/{folder}', ['as' => 'messages.list', 'uses' => 'Messages@messages']);

		Route::get('compose/{message_id?}', ['as' => 'messages.compose', 'uses' => 'Messages@compose']);

	    Route::get('create', ['as' => 'messages.create', 'uses' => 'Messages@create']);

		Route::post('move', ['as' => 'messages.move', 'uses' => 'Messages@move']);

		Route::get('{id}', ['as' => 'messages.read', 'uses' => 'Messages@read']);

	    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'Messages@update']);
	});
});

