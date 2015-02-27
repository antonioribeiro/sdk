<?php

namespace PragmaRX\Sdk\Core\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as IlluminateLoadConfiguration;

class LoadConfiguration extends IlluminateLoadConfiguration {

	private $app;

	public function bootstrap(Application $app)
	{
		$this->app = $app;

		parent::bootstrap($this->app);

		$this->app->config->set('app.providers', array_merge($this->app->config['app.providers'], $this->getSdkProviders($this->app->config['sdk'])));

//		dd($this->app->config['app.providers']);
	}

	private function getSdkProviders($sdk)
	{
		return array_merge(
			$this->getServicesServiceProviders($sdk['services']),
			$this->getPackagesServiceProviders($sdk['packages'])
		);
	}

	private function getServiceServiceProviders($service)
	{
		$path = __DIR__.'/../../..';

		if (file_exists($providersPath = "$path/{$service}/Service/Provider.php"))
		{
			$class = get_class_and_namespace($providersPath);

			return $class[1].'\\'.$class[0];
		}

		return null;
	}

	private function getServicesServiceProviders($services)
	{
		$providers = [];

		foreach($services as $service)
		{
			if ($provider = $this->getServiceServiceProviders($service))
			{
				$providers[] = $provider;
			}
		}

		return $providers;
	}

	private function getPackagesServiceProviders($packages, $disabled_packages = [])
	{
		$providers = [];

		foreach ($packages as $package)
		{
			if ( ! in_array($package['name'], $disabled_packages))
			{
				$providers = array_merge($providers, $this->getPackageServiceProviders($package));
			}
		}

		return $providers;
	}

	private function getPackageServiceProviders($package)
	{
		$providers = [];

		$serviceProviders = ! isset($package['serviceProviders'])
			? []
			: $package['serviceProviders'];

		foreach ($serviceProviders as $serviceProvider)
		{
			if (class_exists($serviceProvider) && $package['enabled'])
			{
				$providers[] = $serviceProvider;
			}
		}

		return $providers;
	}

}
