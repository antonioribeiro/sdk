<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Client\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Chat@create']);

	Route::post('/', ['as' => 'chat.client.store', 'uses' => 'Chat@store']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Chat@chat']);
});

Route::group(['prefix' => 'chat/server', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Server\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.server.index', 'uses' => 'Chat@index']);

	Route::group(['prefix' => 'scripts'], function ()
	{
		Route::get('/', ['as' => 'chat.server.scripts.index', 'uses' => 'Scripts@index']);

		Route::get('create', ['as' => 'chat.server.scripts.create', 'uses' => 'Scripts@create']);

		Route::post('store', ['as' => 'chat.server.scripts.store', 'uses' => 'Scripts@store']);
	});

	Route::get('{chatId}', ['as' => 'chat.server.get', 'uses' => 'Chat@get']);
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Server\Controllers'], function ()
{
	Route::group(['prefix' => 'chat'], function ()
	{
		Route::get('scripts', ['as' => 'api.v1.chat.scripts', 'uses' => 'Api@scripts']);

		Route::get('all', ['as' => 'chat.all', 'uses' => 'Api@all']);

		Route::get('respond/{id}', ['as' => 'chat.respond', 'uses' => 'Api@respond']);

		Route::get('send/{chatId}/{usernameId}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Api@sendMessage']);
	});
});
