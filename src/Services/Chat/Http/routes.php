<?php

Route::group(['prefix' => 'chat', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat', 'uses' => 'Chat@chat']);

	Route::get('new', ['as' => 'chat.new', 'uses' => 'Chat@create']);

	Route::get('send/{username}/{message?}', ['as' => 'chat.send.message', 'uses' => 'Chat@sendMessage']);
});
