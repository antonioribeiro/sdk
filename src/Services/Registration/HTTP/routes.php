<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Registration\Http\Controllers'], function()
{
	Route::group(['prefix' => 'register'], function()
	{
		Route::get('/', ['as' => 'register', 'uses' => 'Registration@create']);

		Route::post('/', ['as' => 'register', 'uses' => 'Registration@store']);
	});
});
