<?php

Route::group(['namespace' => 'PragmaRX\SDK\Accounts'], function()
{
	Route::group(['prefix' => 'account'], function()
	{
		Route::get('activate/{email}/{token}', ['as' => 'account.activate', 'uses' => 'Controller@activate']);
	});
});
