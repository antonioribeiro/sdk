<?php

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Security\Http\Controllers'], function()
{
	Route::group(['prefix' => 'security'], function()
	{
		Route::get('/', ['as' => 'security', 'uses' => 'Security@edit']);
	});
});
