<?php

Route::group(['prefix' => 'chat', 'namespace' => 'PragmaRX\Sdk\Services\Chat\Http\Controllers'], function ()
{
	Route::get('/', ['as' => 'block', 'uses' => 'Chat@index']);

	Route::get('chat/send/{username}/{message}', ['as' => 'block', 'uses' => 'Chat@sendMessage']);
});
