<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Client@create']);

	Route::post('/', ['as' => 'chat.client.store', 'uses' => 'Client@store']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Client@chat']);

	Route::get('send/{chatId}/{username}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Client@sendMessage']);
});

Route::group(['prefix' => 'chat/server', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('all', ['as' => 'chat.server.all', 'uses' => 'Server@all']);

	Route::get('{chatId}', ['as' => 'chat.server.get', 'uses' => 'Server@get']);
});
