<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Messaging\Http\Controllers'], function()
{
	Route::group(['prefix' => 'message'], function()
	{
		Route::get('/', ['as' => 'message', 'uses' => 'Messaging@index']);
	});
});
