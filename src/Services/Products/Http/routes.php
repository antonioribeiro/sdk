<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Products\Http\Controllers'], function()
{
	Route::group(['prefix' => 'clipping'], function()
	{
		Route::get('/', ['as' => 'clipping', 'uses' => 'Products@index']);

		Route::get('post/{id}', ['as' => 'clipping.post', 'uses' => 'Products@post']);
	});
});
