<?php namespace PragmaRX\Sdk\Services\Scraper;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use PragmaRX\Sdk\Console\ScrapeLinksCommand;
use PragmaRX\Sdk\Entities\Ads\AdRepository;
use PragmaRX\Sdk\Entities\Realties\RealtyRepository;
use PragmaRX\Sdk\Entities\Webservices\WebserviceRepository;

class DeepScraperServiceProvider extends IlluminateServiceProvider {

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
		$this->app['pragmarx.deep.scraper'] = $this->app->share(function($app)
		{
			$realtyRepository = new RealtyRepository;

			return new DeepScraper(
				new AdRepository($realtyRepository),
				new WebserviceRepository,
				$realtyRepository
			);
		});

		$this->registerScrapeLinksCommand();
	}

    private function registerScrapeLinksCommand()
    {
        $this->app['imobiliario.commands.scrape.links'] = $this->app->share(function($app)
        {
            return new ScrapeLinksCommand();
        });

	    $this->commands('imobiliario.commands.scrape.links');
    }

}
