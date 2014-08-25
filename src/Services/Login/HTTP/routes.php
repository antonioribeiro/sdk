<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Login\Http\Controllers'], function()
{
	Route::group(['prefix' => 'login'], function()
	{
		Route::get('/', ['as' => 'login', 'uses' => 'Login@create']);

		Route::post('/', ['as' => 'login', 'uses' => 'Login@store']);
	});

	Route::get('/logout', ['as' => 'logout', 'uses' => 'Login@destroy']);
});
