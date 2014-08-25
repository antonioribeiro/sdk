<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Statuses\Http\Controllers'], function()
{
	Route::group(['prefix' => 'statuses'], function()
	{
		Route::get('/', ['as' => 'statuses', 'uses' => 'Statuses@index']);

		Route::post('/', ['as' => 'statuses', 'uses' => 'Statuses@store']);
	});
});
