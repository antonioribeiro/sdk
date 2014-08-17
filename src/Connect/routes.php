<?php

Route::group(['namespace' => 'PragmaRX\SDK\Connect'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::get('{username}', ['as' => 'connect', 'uses' => 'Controller@store']);
	});

	Route::group(['prefix' => 'disconnect'], function()
	{
		Route::get('{username}', ['as' => 'disconnect', 'uses' => 'Controller@destroy']);
	});
});
