<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Follow\Http\Controllers'], function()
{
	Route::group(['prefix' => 'follow'], function()
	{
		Route::get('{username}', ['as' => 'follow', 'uses' => 'Follow@store']);
	});

	Route::group(['prefix' => 'unfollow'], function()
	{
		Route::get('{username}', ['as' => 'unfollow', 'uses' => 'Follow@destroy']);
	});
});
