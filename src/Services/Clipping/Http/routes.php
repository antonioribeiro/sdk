<?php

Route::group(['before' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Clipping\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::post('invite', ['as' => 'connect.invite', 'uses' => 'Clipping@invite']);

		Route::post('invite/validate', ['as' => 'connect.invite.validate', 'uses' => 'Clipping@inviteValidate']);

		Route::post('{user_id}/{action}', ['as' => 'connect.action', 'uses' => 'Clipping@takeAction']);

		Route::get('{username}', ['as' => 'connect', 'uses' => 'Clipping@store']);
	});

	Route::group(['prefix' => 'disconnect'], function()
	{
		Route::get('{username}', ['as' => 'disconnect', 'uses' => 'Clipping@destroy']);
	});

	Route::group(['prefix' => 'connections'], function()
	{
		Route::get('/', ['as' => 'connections', 'uses' => 'Clippingions@index']);
	});
});

// Not athenticated routes

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Clipping\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::get('invite/accept/{id}', ['as' => 'connect.invite.accept', 'uses' => 'Clipping@acceptInvitation']);
	});
});
