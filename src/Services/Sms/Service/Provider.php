<?php

namespace PragmaRX\Sdk\Services\Sms\Service;

use PragmaRX\Support\ServiceProvider;
use Aloha\Twilio\Twilio;

class Provider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['pragmarx.sms'] = $this->app->share(function($app)
		{
			return new Sms($app['twilio']);
		});
	}

	public function boot()
	{
//		$this->app['config']->package('aloha/twilio', base_path().'/config/packages/aloha/twilio', 'aloha/twilio');
//
//		$this->app['config']->set('aloha/twilio::twilio.sid', env());
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.sms'];
	}

}
