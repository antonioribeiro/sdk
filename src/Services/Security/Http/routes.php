<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Security\Http\Controllers'], function()
{
	Route::group(['prefix' => 'security'], function()
	{
		Route::get('/', ['as' => 'security', 'uses' => 'Security@edit']);

		Route::patch('google', ['as' => 'security.google', 'uses' => 'Security@google']);
	});
});
