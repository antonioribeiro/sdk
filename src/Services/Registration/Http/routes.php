<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Registration\Http\Controllers'], function()
{
	Route::group(['before' => 'guest', 'prefix' => 'register'], function()
	{
		Route::get('/{invite_code?}', ['as' => 'register', 'uses' => 'Registration@create']);

		Route::post('/', ['as' => 'register', 'uses' => 'Registration@store']);
	});
});
