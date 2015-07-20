<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Clipping\Http\Controllers'], function()
{
	Route::group(['prefix' => 'clipping'], function()
	{
		Route::get('/', ['as' => 'clipping', 'uses' => 'Clipping@index']);

		Route::get('post/{id}', ['as' => 'clipping.post', 'uses' => 'Clipping@post']);
	});
});
