<?php

Route::group(['namespace' => 'PragmaRX\SDK\Login'], function()
{
	Route::group(['prefix' => 'login'], function()
	{
		Route::get('/', ['as' => 'login', 'uses' => 'Controller@create']);

		Route::post('/', ['as' => 'login', 'uses' => 'Controller@store']);
	});

	Route::get('/logout', ['as' => 'logout', 'uses' => 'Controller@destroy']);
});
