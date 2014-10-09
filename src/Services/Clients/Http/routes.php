<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Clients\Http\Controllers'], function()
{
	Route::group(['prefix' => 'clients'], function()
	{
		Route::get('/', ['as' => 'clients', 'uses' => 'Clients@index']);

		Route::get('validate', ['as' => 'clients.validate', 'uses' => 'Clients@validate']);
	});
});

