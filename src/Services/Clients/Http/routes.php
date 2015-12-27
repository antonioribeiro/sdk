<?php

Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Clients\Http\Controllers'], function()
{
	Route::group(['prefix' => 'clients'], function()
	{
		Route::get('/', ['as' => 'clients', 'uses' => 'Clients@index']);

		Route::post('/', ['as' => 'clients', 'uses' => 'Clients@post']);

		Route::post('validate', ['as' => 'clients.validate', 'uses' => 'Clients@validateData']);

		Route::get('edit/{id}', ['as' => 'clients.edit', 'uses' => 'Clients@edit']);

		Route::patch('edit/{id}', ['as' => 'clients.edit', 'uses' => 'Clients@update']);

		Route::delete('delete/{id}', ['as' => 'clients.delete', 'uses' => 'Clients@delete']);
	});
});
