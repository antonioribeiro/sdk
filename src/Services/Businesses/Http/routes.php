<?php

Route::group(['prefix' => 'businesses', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Businesses\Http\Controllers'], function ()
{
	Route::get('users', ['as' => 'businesses.users.index', 'uses' => 'Users@index']);

	Route::get('users/create', ['as' => 'businesses.users.create', 'uses' => 'Users@create']);

	Route::post('users/store', ['as' => 'businesses.users.store', 'uses' => 'Users@store']);
});
