<?php

namespace Imobiliario\Services\Scraper;

use Goutte\Client as Goutte;

abstract class BaseScraper implements ScraperInterface {

	/**
	 * @var \Symfony\Component\DomCrawler\Crawler
	 */
	private $crawler;

	/**
	 * @var
	 */
	private $currentUrl;

	/**
	 * @var string
	 */
	private $method = 'GET';

	/**
	 * @var Goutte
	 */
	private $goutte;

	protected $rules = [];

	protected $data = [];

	protected $hasContent = false;

	protected $webserviceName;

	/**
	 * @param Goutte $goutte
	 */
	public function __construct(Goutte $goutte = null)
	{
	    $this->goutte = new Goutte();
	}

	/**
	 * @return array
	 */
	public function links()
	{
		$links = [];

		foreach($this->crawler->filter($this->rules['links'])->links() as $link)
		{
			$links[] = $link->getUri();
		}

		return $this->scrapeLinks($links);
	}

	/**
	 * @return mixed
	 */
	public function getUrl()
	{
		return $this->rules['url'];
	}

	/**
	 * @param mixed $url
	 */
	public function setUrl($url)
	{
		$this->currentUrl = $url;

		$this->request($url);
	}

	/**
	 * @param mixed $method
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}

	/**
	 * @param null $url
	 * @param null $method
	 * @return mixed
	 */
	private function request($url = null, $method = null)
	{
		$this->crawler = $this->goutte->request(
			$method ?: $this->method,
			$url ?: $this->currentUrl
		);

		$this->hasContent = true;

		return $this->crawler;
	}

	/**
	 * Generate urls to be scraped.
	 *
	 * @return array
	 */
	public function generateUrls()
    {
	    return array_strings_generator($this->data, $this->rules['url']);
    }

	public function nextPage()
	{
		$filter = $this->crawler->filter($this->rules['next.page.link']);

		try
		{
			$link = $filter->links()[0];

			$this->crawler = $this->goutte->click($link);
		}
		catch(\Exception $e)
		{
			$this->hasContent = false;
		}
	}

	public function getWebserviceName()
	{
		return $this->webserviceName;
	}

	private function scrapeLinks($links)
	{
		foreach($links as $key => $link)
		{
			$links[$key] = $this->scrapeLink($link);
		}

		return $links;
	}

}
