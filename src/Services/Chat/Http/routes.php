<?php

Route::group(['prefix' => 'chat', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'chat', 'uses' => 'Chat@chat']);

	Route::get('create', ['as' => 'chat.create', 'uses' => 'Chat@create']);

	Route::post('create', ['as' => 'chat.store', 'uses' => 'Chat@store']);

	Route::get('send/{username}/{message?}', ['as' => 'chat.send.message', 'uses' => 'Chat@sendMessage']);
});
