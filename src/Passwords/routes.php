<?php

Route::group(['namespace' => 'PragmaRX\SDK\Passwords'], function()
{
	Route::group(['prefix' => 'password'], function()
	{
		Route::get('/', ['as' => 'password', 'uses' => 'Controller@create']);

		Route::post('/', ['as' => 'password', 'uses' => 'Controller@store']);

		Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'Controller@reset']);

		Route::post('reset', ['as' => 'password.reset', 'uses' => 'Controller@update']);
	});
});
