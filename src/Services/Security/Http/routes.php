<?php

Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Security\Http\Controllers'], function()
{
	Route::group(['prefix' => 'security'], function()
	{
		Route::get('/', ['as' => 'security', 'uses' => 'Security@edit']);

		Route::patch('google', ['as' => 'security.google', 'uses' => 'Security@google']);

		Route::patch('email', ['as' => 'security.email', 'uses' => 'Security@email']);

		Route::get('email/toggle/{token}', ['as' => 'security.email.toggle', 'uses' => 'Security@emailToggle']);
	});
});
