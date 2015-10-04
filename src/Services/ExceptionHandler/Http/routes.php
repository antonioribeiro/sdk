<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\ExceptionHandler\Http\Controllers'], function()
{
	Route::group(['prefix' => 'error'], function()
	{
		Route::get('{code}', ['as' => 'error', 'uses' => 'Errors@show']);
	});
});
