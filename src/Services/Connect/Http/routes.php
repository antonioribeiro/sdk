<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Connect\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::get('{username}', ['as' => 'connect', 'uses' => 'Connect@store']);

		Route::get('{user_id}/{action}', ['as' => 'connect.action', 'uses' => 'Connect@takeAction']);
	});

	Route::group(['prefix' => 'disconnect'], function()
	{
		Route::get('{username}', ['as' => 'disconnect', 'uses' => 'Connect@destroy']);
	});

	Route::group(['prefix' => 'connections'], function()
	{
		Route::get('/', ['as' => 'connections', 'uses' => 'Connections@index']);
	});
});
