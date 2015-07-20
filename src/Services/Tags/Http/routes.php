<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Tags\Http\Controllers'], function()
{
	Route::group(['prefix' => 'clients'], function()
	{
		Route::get('/', ['as' => 'clients', 'uses' => 'Tags@index']);

		Route::post('/', ['as' => 'clients', 'uses' => 'Tags@post']);

		Route::post('validate', ['as' => 'clients.validate', 'uses' => 'Tags@validate']);

		Route::get('edit/{id}', ['as' => 'clients.edit', 'uses' => 'Tags@edit']);

		Route::patch('edit/{id}', ['as' => 'clients.edit', 'uses' => 'Tags@update']);

		Route::delete('delete/{id}', ['as' => 'clients.delete', 'uses' => 'Tags@delete']);
	});
});
