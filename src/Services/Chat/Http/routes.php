<?php

Route::group(['prefix' => 'chat/client', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.client.create', 'uses' => 'Chat@create']);

	Route::get('/{id}', ['as' => 'chat.client', 'uses' => 'Chat@chat']);

	Route::post('create', ['as' => 'chat.client.store', 'uses' => 'Chat@store']);

	Route::get('send/{username}/{message?}', ['as' => 'chat.client.send.message', 'uses' => 'Chat@sendMessage']);
});
