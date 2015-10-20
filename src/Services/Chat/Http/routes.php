<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Client\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Home@create']);

	Route::post('/', ['as' => 'chat.client.store', 'uses' => 'Home@store']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Home@chat']);

	Route::get('send/{chatId}/{usernameId}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Home@sendMessage']);
});

Route::group(['prefix' => 'chat/server', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Server\Controllers'], function ()
{
	Route::get('all', ['as' => 'chat.server.all', 'uses' => 'Home@all']);

	Route::get('{chatId}', ['as' => 'chat.server.get', 'uses' => 'Home@get']);

	Route::get('scripts', ['as' => 'chat.server.scripts.index', 'uses' => 'Home@get']);
});
