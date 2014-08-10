<?php

Route::group(['namespace' => 'PragmaRX\SDK\Messaging'], function()
{
	Route::group(['prefix' => 'message'], function()
	{
		Route::get('/', ['as' => 'message', 'uses' => 'Controller@index']);
	});
});
