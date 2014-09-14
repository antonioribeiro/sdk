<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Language\Http\Controllers'], function()
{
	Route::group(['prefix' => 'language'], function()
	{
		Route::get('{lang}', ['as' => 'language', 'uses' => 'Language@change']);
	});
});
