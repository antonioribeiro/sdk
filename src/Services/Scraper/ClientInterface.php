<?php

namespace PragmaRX\Sdk\Services\Scraper;

interface ClientInterface
{

	public function request($url, $method = 'GET');

	public function getCrawler($url, $method = 'GET');

}
