<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Messaging\HTTP\Controllers'], function()
{
	Route::group(['prefix' => 'message'], function()
	{
		Route::get('/', ['as' => 'message', 'uses' => 'Messaging@index']);
	});
});
