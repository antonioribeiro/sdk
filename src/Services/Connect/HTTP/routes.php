<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Connect\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::get('{username}', ['as' => 'connect', 'uses' => 'Connect@store']);
	});

	Route::group(['prefix' => 'disconnect'], function()
	{
		Route::get('{username}', ['as' => 'disconnect', 'uses' => 'Connect@destroy']);
	});
});
