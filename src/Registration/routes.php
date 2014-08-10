<?php

Route::group(['namespace' => 'PragmaRX\SDK\Registration'], function()
{
	Route::group(['prefix' => 'register'], function()
	{
		Route::get('/', ['as' => 'register', 'uses' => 'Controller@create']);

		Route::post('/', ['as' => 'register', 'uses' => 'Controller@store']);
	});
});
