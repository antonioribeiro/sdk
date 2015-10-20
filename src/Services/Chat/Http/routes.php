<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Client\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Home@create']);

	Route::post('/', ['as' => 'chat.client.store', 'uses' => 'Home@store']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Home@chat']);

	Route::get('send/{chatId}/{usernameId}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Home@sendMessage']);
});

Route::group(['prefix' => 'chat/server', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Server\Controllers'], function ()
{
	Route::get('all', ['as' => 'chat.server.all', 'uses' => 'Home@all']);

	Route::group(['prefix' => 'scripts'], function ()
	{
		Route::get('/', ['as' => 'chat.server.scripts.index', 'uses' => 'Scripts@index']);

		Route::get('create', ['as' => 'chat.server.scripts.create', 'uses' => 'Scripts@create']);

		Route::post('store', ['as' => 'chat.server.scripts.store', 'uses' => 'Scripts@store']);
	});

	Route::get('{chatId}', ['as' => 'chat.server.get', 'uses' => 'Home@get']);
});
