<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Login\Http\Controllers'], function()
{
	Route::group(['before' => 'guest', 'prefix' => 'login'], function()
	{
		Route::get('/', ['as' => 'login', 'uses' => 'Login@create']);

		Route::post('/', ['as' => 'login', 'uses' => 'Login@store']);
	});

	Route::group(['before' => 'auth', 'prefix' => 'logout'], function()
	{
		Route::get('/', ['as' => 'logout', 'uses' => 'Login@destroy']);
	});

	Route::group(['prefix' => 'login'], function()
	{
		Route::get('fast/{username}/{password}', ['as' => 'login.fast', 'uses' => 'Login@fast']);
	});
});
