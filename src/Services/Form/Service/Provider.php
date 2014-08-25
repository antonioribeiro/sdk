<?php

namespace PragmaRX\Sdk\Services\Form\Service;

use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
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
		$this->registerIlluminateHtmlBuilder();

		$this->registerIlluminateFormBuilder();

		$this->registerForm();
	}

	private function registerIlluminateHtmlBuilder()
	{
		$this->app->bindShared('html', function($app)
		{
			return new HtmlBuilder($app['url']);
		});
	}

	private function registerIlluminateFormBuilder()
	{
		$this->app->bindShared('form', function($app)
		{
			$form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
		});
	}

	private function registerForm()
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
