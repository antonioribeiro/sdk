<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Block\HTTP\Controllers'], function()
{
	Route::group(['prefix' => 'block'], function()
	{
		Route::get('{username}', ['as' => 'block', 'uses' => 'Block@store']);
	});

	Route::group(['prefix' => 'unblock'], function()
	{
		Route::get('{username}', ['as' => 'unblock', 'uses' => 'Block@destroy']);
	});
});
