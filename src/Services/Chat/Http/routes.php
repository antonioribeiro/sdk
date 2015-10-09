<?php

Route::group(['prefix' => 'chat', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat.index', 'uses' => 'Chat@index']);

	Route::get('chat/send/{username}/{message}', ['as' => 'chat.send.message', 'uses' => 'Chat@sendMessage']);
});
