<?php

Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\EmailChanges\Http\Controllers'], function()
{
	Route::group(['prefix' => 'email/change'], function()
	{
		Route::get('{token}', ['as' => 'email.change', 'uses' => 'EmailChanges@change']);

		Route::get('report/{token}', ['as' => 'email.change.report', 'uses' => 'EmailChanges@report']);
	});
});
