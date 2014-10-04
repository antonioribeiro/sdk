<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Login\Http\Controllers'], function()
{
	Route::group(['before' => 'guestx', 'prefix' => 'auth/login'], function()
	{
		Route::get('/', ['as' => 'login', 'uses' => 'Login@create']);

		Route::post('/', ['as' => 'login', 'uses' => 'Login@store']);

		Route::get('{username}/{password}', ['as' => 'login.fast', 'uses' => 'Login@store']);
	});

	Route::group(['before' => 'auth', 'prefix' => 'auth/logout'], function()
	{
		Route::get('/', ['as' => 'logout', 'uses' => 'Login@destroy']);
	});
});
