<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Statuses\HTTP\Controllers'], function()
{
	Route::group(['prefix' => 'statuses'], function()
	{
		Route::get('/', ['as' => 'statuses', 'uses' => 'Statuses@index']);

		Route::post('/', ['as' => 'statuses', 'uses' => 'Statuses@store']);
	});
});