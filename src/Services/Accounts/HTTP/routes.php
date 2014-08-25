<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Accounts\Http\Controllers'], function()
{
	Route::group(['prefix' => 'account'], function()
	{
		Route::get('activate/{email}/{token}', ['as' => 'account.activate', 'uses' => 'Accounts@activate']);
	});
});
