<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Users\Http\Controllers'], function()
{
	Route::group(['prefix' => 'users'], function()
	{
		Route::get('/', ['as' => 'users.index', 'uses' => 'Users@index']);
	});
});
