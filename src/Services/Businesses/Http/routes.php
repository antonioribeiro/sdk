<?php

Route::group(['prefix' => 'businesses', 'namespace' => 'PragmaRX\Sdk\Services\Businesses\Http\Controllers'], function ()
{
	Route::get('users', ['as' => 'businesses.users.index', 'uses' => 'Users@index']);
});
