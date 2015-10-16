<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Chat@create']);

	Route::post('/', ['as' => 'chat.client.store', 'uses' => 'Chat@store']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Chat@chat']);

	Route::get('send/{chatId}/{username}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Chat@sendMessage']);
});
