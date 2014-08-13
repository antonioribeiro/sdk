<?php

Route::group(['namespace' => 'PragmaRX\SDK\Follow'], function()
{
	Route::group(['prefix' => 'follow'], function()
	{
		Route::get('{username}', ['as' => 'follow', 'uses' => 'Controller@store']);
	});

	Route::group(['prefix' => 'unfollow'], function()
	{
		Route::get('{username}', ['as' => 'unfollow', 'uses' => 'Controller@destroy']);
	});
});

