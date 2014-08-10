<?php

Route::group(['namespace' => 'PragmaRX\SDK\Account'], function()
{
	Route::group(['prefix' => 'account'], function()
	{
		Route::get('activate/{email}/{token}', ['as' => 'account.activate', 'uses' => 'Controller@activate']);
	});
});
