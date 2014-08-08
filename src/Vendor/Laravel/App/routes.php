<?php

$prefix = Config::get('pragmarx/sdk::stats_base_uri');

$namespace = Config::get('pragmarx/sdk::stats_controllers_namespace');

$filter = Config::get('pragmarx/sdk::stats_routes_before_filter');

Route::group(['namespace' => $namespace], function() use ($prefix, $filter)
{
	Route::group(['before' => $filter], function() use ($prefix, $filter)
	{
		Route::group(['prefix' => $prefix], function()
		{
			Route::get('/', array('as' => 'sdk.stats.index', 'uses' => 'Stats@index'));

			Route::get('log/{uuid}', array('as' => 'sdk.stats.log', 'uses' => 'Stats@log'));

			Route::get('api/pageviews', array('as' => 'sdk.stats.api.pageviews', 'uses' => 'Stats@apiPageviews'));

			Route::get('api/pageviewsbycountry', array('as' => 'sdk.stats.api.pageviewsbycountry', 'uses' => 'Stats@apiPageviewsByCountry'));

			Route::get('api/log/{uuid}', array('as' => 'sdk.stats.api.log', 'uses' => 'Stats@apiLog'));

			Route::get('api/errors', array('as' => 'sdk.stats.api.errors', 'uses' => 'Stats@apiErrors'));

			Route::get('api/events', array('as' => 'sdk.stats.api.events', 'uses' => 'Stats@apiEvents'));

			Route::get('api/users', array('as' => 'sdk.stats.api.users', 'uses' => 'Stats@apiUsers'));

			Route::get('api/visits', array('as' => 'sdk.stats.api.visits', 'uses' => 'Stats@apiVisits'));
		});
	});
});
