<?php

Route::group(['namespace' => 'PragmaRX\SDK\Profiles'], function()
{
	Route::group(['prefix' => 'profile'], function()
	{
		Route::get('{username}', ['as' => 'profile', 'uses' => 'Controller@show']);
	});
});
