<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 05/08/2014
 * Time: 14:13
 */

namespace Imobiliario\Services\Scraper;


use Imobiliario\Entities\Ads\AdRepository;
use Imobiliario\Entities\Realties\RealtyRepository;
use Imobiliario\Entities\Webservices\WebserviceRepository;

class DeepScraper {

	/**
	 * @var AdRepository
	 */
	private $adRepository;

	/**
	 * @var WebserviceRepository
	 */
	private $webServiceRepository;

	/**
	 * @var RealtyRepository
	 */
	private $realtyRepository;

	public function __construct(
		AdRepository $adRepository,
		WebserviceRepository $webServiceRepository,
		RealtyRepository $realtyRepository
	)
	{
		$this->adRepository = $adRepository;

		$this->webServiceRepository = $webServiceRepository;

		$this->realtyRepository = $realtyRepository;
	}

	public function links($command)
	{
		$scraper = new ZapScraper();

		$links = $scraper->getLinks();

		$command->info('count = '.count($links));

		// $webservice = $this->webServiceRepository->findByName($scraper->getWebserviceName());

		foreach($scraper->getLinks() as $link)
		{
			$this->adRepository->importLink(
				$link,
			    1 //$webservice->id
			);
		}

	}

}
