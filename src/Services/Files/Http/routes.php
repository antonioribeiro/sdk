<?php

Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Files\Http\Controllers'], function()
{
	Route::group(['prefix' => 'files'], function()
	{
		Route::post('/', ['as' => 'files.upload', 'uses' => 'Files@upload']);
	});
});
