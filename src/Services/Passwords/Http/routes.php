<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Passwords\Http\Controllers'], function()
{
	Route::group(['prefix' => 'password'], function()
	{
		Route::get('/', ['as' => 'password', 'uses' => 'Passwords@create']);

		Route::post('/', ['as' => 'password', 'uses' => 'Passwords@store']);

		Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'Passwords@reset']);

		Route::post('reset', ['as' => 'password.reset', 'uses' => 'Passwords@update']);
	});
});
