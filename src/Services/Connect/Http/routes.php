<?php

Route::group(['middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Connect\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::post('invite', ['as' => 'connect.invite', 'uses' => 'Connect@invite']);

		Route::post('invite/validate', ['as' => 'connect.invite.validate', 'uses' => 'Connect@inviteValidate']);

		Route::post('{user_id}/{action}', ['as' => 'connect.action', 'uses' => 'Connect@takeAction']);

		Route::get('{username}', ['as' => 'connect', 'uses' => 'Connect@store']);
	});

	Route::group(['prefix' => 'disconnect'], function()
	{
		Route::get('{username}', ['as' => 'disconnect', 'uses' => 'Connect@destroy']);
	});

	Route::group(['prefix' => 'connections'], function()
	{
		Route::get('/', ['as' => 'connections', 'uses' => 'Connections@index']);
	});
});

// Not athenticated routes

Route::group(['namespace' => 'PragmaRX\Sdk\Services\Connect\Http\Controllers'], function()
{
	Route::group(['prefix' => 'connect'], function()
	{
		Route::get('invite/accept/{id}', ['as' => 'connect.invite.accept', 'uses' => 'Connect@acceptInvitation']);
	});
});
