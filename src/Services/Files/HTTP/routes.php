<?php

Route::group(['namespace' => 'PragmaRX\SDK\Services\Files\HTTP\Controllers'], function()
{
	Route::group(['prefix' => 'files'], function()
	{
		Route::post('/', ['as' => 'files.upload', 'uses' => 'Files@upload']);
	});
});
