<?php

namespace PragmaRX\Sdk\Services\Form\Service;

use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use PragmaRX\Support\ServiceProvider;

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
		$this->registerIlluminateHtmlBuilder();

		$this->registerIlluminateFormBuilder();

		$this->registerForm();
	}

	private function registerIlluminateHtmlBuilder()
	{
		$this->app->singleton('html', function($app)
		{
			return new HtmlBuilder($app['url'], $app['view']);
		});
	}

	private function registerIlluminateFormBuilder()
	{
		$this->app->singleton('form', function($app)
		{
			$form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
		});
	}

	private function registerForm()
	{
		$this->app->singleton('pragmarx.form', function($app)
		{
			return app(Form::class);
		});

//		$this->app->singleton('pragmarx.form', function($app)
//		{
//			$form = new Form($app['html'], $app['url'], $app['session.store']->getToken());
//
//			return $form->setSessionStore($app['session.store']);
//		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.form', 'html', 'form'];
	}


	/**
	 * Get the current package directory.
	 *
	 * @return string
	 */
	public function getPackageDir()
	{
		return __DIR__;
	}

}
