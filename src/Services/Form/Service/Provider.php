<?php

namespace PragmaRX\SDK\Services\Form\Service;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class Provider extends IlluminateServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('pragmarx.form', function($app)
		{
			return new Form();
		});

//		$this->app->bindShared('pragmarx.form', function($app)
//		{
//			$form = new Form($app['html'], $app['url'], $app['session.store']->getToken());
//
//			return $form->setSessionStore($app['session.store']);
//		});
	}

}
