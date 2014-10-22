<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Groups\Http\Controllers'], function()
{
	Route::group(['prefix' => 'groups'], function()
	{
		Route::get('/', ['as' => 'groups', 'uses' => 'Groups@index']);

		Route::post('/', ['as' => 'groups', 'uses' => 'Groups@store']);

		Route::post('/validate', ['as' => 'groups.validate', 'uses' => 'Groups@validate']);
	});
});
