<?php

Route::group(['prefix' => 'businesses', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Businesses\Http\Controllers'], function ()
{
	Route::get('users', ['as' => 'businesses.users.index', 'uses' => 'Users@index']);

	Route::get('edit/{id}', ['as' => 'businesses.users.edit', 'uses' => 'Users@edit']);

	Route::get('users/delete/{id}', ['as' => 'businesses.users.delete', 'uses' => 'Users@delete']);

	Route::get('users/create', ['as' => 'businesses.users.create', 'uses' => 'Users@create']);

	Route::post('users/store', ['as' => 'businesses.users.store', 'uses' => 'Users@store']);

	Route::post('users/update', ['as' => 'businesses.users.update', 'uses' => 'Users@update']);
});
