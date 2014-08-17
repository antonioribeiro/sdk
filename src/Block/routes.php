<?php

Route::group(['namespace' => 'PragmaRX\SDK\Block'], function()
{
	Route::group(['prefix' => 'block'], function()
	{
		Route::get('{username}', ['as' => 'block', 'uses' => 'Controller@store']);
	});

	Route::group(['prefix' => 'unblock'], function()
	{
		Route::get('{username}', ['as' => 'unblock', 'uses' => 'Controller@destroy']);
	});
});
