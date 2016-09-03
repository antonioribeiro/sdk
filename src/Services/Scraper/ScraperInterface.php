<?php

namespace Imobiliario\Services\Scraper;

interface ScraperInterface
{

	public function links();

	public function scrapeLink($url);

}
