<?php

namespace PragmaRX\Sdk\Services\Scraper;

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
	    if (! $goutte)
        {
            $goutte = new Goutte();
        }

        $this->goutte = $goutte;
	}

    /**
     * @return string
     */
    public function getCrawler()
    {
        return $this->crawler;
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
     * @return mixed
     */
	public function setUrl($url)
	{
		$this->currentUrl = $url;

		return $this->request($url);
	}

    public function getContent($url)
    {
        return $this->setUrl($url);
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
	private function request($url = null, $method = 'GET')
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

	public function nextPage($url, $page = null)
	{
	    if (! $page)
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
        else
        {
            $query = str_replace('%page%', $page, $this->rules['next.page.query']);

            $this->setUrl($url = $url.$query);
            $this->log(null, $url);
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

    /**
     * @param $command
     * @param $log
     */
    public function log($command, $log)
    {
        if ($command) {
            $command->info($log);
        }
        else {
            echo "$log<br>";
        }
    }
}
