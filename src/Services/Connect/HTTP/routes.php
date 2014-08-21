<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Connect\HTTP\Controllers'], function()
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
