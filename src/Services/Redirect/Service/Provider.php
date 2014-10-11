<?php

namespace PragmaRX\Sdk\Services\Redirect\Service;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['redirect'] = $this->app->share(function($app)
		{
			$redirector = new Redirect($app['url']);

			// If the session is set on the application instance, we'll inject it into
			// the redirector instance. This allows the redirect responses to allow
			// for the quite convenient "with" methods that flash to the session.
			if (isset($app['session.store']))
			{
				$redirector->setSession($app['session.store']);
			}

			return $redirector;
		});
	}

}
