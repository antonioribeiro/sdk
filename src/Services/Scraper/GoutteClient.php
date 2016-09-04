<?php

namespace PragmaRX\Sdk\Services\Scraper;

use Goutte\Client as Goutte;

class GoutteClient implements ClientInterface
{

	private $method;

	private $url;

	private $crawler;

	function __construct()
	{
		$this->client = new Goutte();
	}

	public function request($url, $method = 'GET')
	{
		if ( ! $this->crawler || $url !== $this->url || $this->method !== $method)
		{
			$this->crawler = $this->client->request($method, $url);

			$this->url = $url;

			$this->method = $method;
		}

		return $this->crawler;
	}

	public function getCrawler($url, $method = 'GET')
	{
	    if ( ! $this->crawler)
	    {
		    $this->request($url, $method);
	    }

		return $this->crawler;
	}

}
