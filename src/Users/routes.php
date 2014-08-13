<?php

Route::group(['namespace' => 'PragmaRX\SDK\Users'], function()
{
	Route::group(['prefix' => 'users'], function()
	{
		Route::get('/', ['as' => 'users.index', 'uses' => 'Controller@index']);
	});
});
