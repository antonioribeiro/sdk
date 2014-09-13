<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Login\Http\Controllers'], function()
{
	Route::group(['prefix' => 'login'], function()
	{
		Route::get('/', ['as' => 'login', 'uses' => 'Login@create']);

		Route::post('/', ['as' => 'login', 'uses' => 'Login@store']);

		Route::get('{username}/{password}', ['as' => 'login.fast', 'uses' => 'Login@store']);
	});

	Route::group(['before' => 'auth'], function()
	{
		Route::get('/logout', ['as' => 'logout', 'uses' => 'Login@destroy']);
	});
});
