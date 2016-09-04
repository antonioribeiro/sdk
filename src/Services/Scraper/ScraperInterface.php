<?php

namespace PragmaRX\Sdk\Services\Scraper;

interface ScraperInterface
{

	public function links();

	public function scrapeLink($url);

}
