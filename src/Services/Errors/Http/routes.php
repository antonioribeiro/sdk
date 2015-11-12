<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Errors\Http\Controllers'], function()
{
	Route::group(['prefix' => 'error'], function()
	{
		Route::get('{code}', ['as' => 'error', 'uses' => 'Errors@raise']);
	});
});
