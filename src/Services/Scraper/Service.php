<?php

namespace PragmaRX\Sdk\Services\Scraper;

class Service
{

	/**
	 * The crawlable url.
	 *
	 * @var null
	 */
	protected $url;

	/**
	 * The crawler.
	 *
	 * @var
	 */
	private $crawler;

	/**
	 * The rules.
	 *
	 * @var null
	 */
	private $rules;

	/**
	 * The current filter.
	 *
	 * @var
	 */
	private $filter;

	/**
	 * @var null
	 */
	private $data;

	/**
	 * Instantiate the Scraper.
	 *
	 * @param null $rules
	 */
	function __construct(ClientInterface $client, $rules = null, $data = null)
	{
		$this->data = $data;

		$this->setRules($rules);

		$this->client = $client;
	}

	/**
	 * Set the url.
	 *
	 * @param $url
	 * @return null
	 */
	public function setUrl($url)
    {
        $this->url = $url;

	    return $this->url;
    }

	/**
	 * Get the url.
	 *
	 * @return null
	 */
	public function getUrl()
    {
        return $this->url;
    }

	/**
	 * Get the client.
	 *
	 * @return Client
	 */
	public function getClient()
    {
        return $this->client;
    }

	/**
	 * Get the crawler.
	 *
	 * @return \Symfony\Component\DomCrawler\Crawler
	 */
	public function crawler()
    {
        return $this->client->getCrawler($this->url);
    }

	/**
	 * Set the rules.
	 *
	 * @param $rules
	 * @return null
	 */
	public function setRules($rules)
    {
        $this->rules = $rules;

	    $this->parseRules();

	    return $this->rules;
    }

	/**
	 * Get the rules.
	 *
	 * @return null
	 */
	public function getRules()
    {
        return $this->rules;
    }

	/**
	 * It filters a content.
	 *
	 * @param $rule
	 * @return \Symfony\Component\DomCrawler\Crawler
	 */
	public function filter($rule)
    {
//	    $this->filter = $this->crawler()->filter($rule);

	    $this->filter = $this->client->getCrawler($this->url)->filter($rule)->html();

		$this->filter = $this->getClient()->request($this->url)->filter($rule);

		dd($this->filter->html());

        return $this;
    }

	/**
	 * It filters a content.
	 *
	 * @return \Symfony\Component\DomCrawler\Crawler
	 */
	public function each($closure)
    {
	    return $this->crawler()->each($closure);
    }

	/**
	 * It extracts a content.
	 *
	 * @param $rule
	 * @param string $method
	 * @return $this
	 */
	public function extract($rule, $method = 'first')
    {
	    $this->filter = $this->getFilter($rule)->{$method}();

        return $this;
    }

	/**
	 * Gets the current filter.
	 *
	 * @return \Symfony\Component\DomCrawler\Crawler
	 */
	public function getFilter($rule = 'html')
	{
		if ( ! $this->filter)
		{
			$this->filter($rule);
		}

		return $this->filter;
	}

	/**
	 * Get the first element of a filtered element.
	 *
	 * @return $this
	 */
	public function first()
	{
		$this->filter = $this->getFilter()->first();

		return $this;
	}

	/**
	 * Returns the filtered HTML.
	 *
	 * @return string
	 */
	public function html()
    {
        return $this->getFilter()->html();
    }

	/**
	 * Retrieve all results from a url.
	 *
	 */
	public function getResults()
    {
	    $results = [];


		return [];
    }

	public function getLinks()
	{

		$goutte = new \Goutte\Client();
		$crawler = $goutte->request('GET', 'http://development.imobiliar.io/zap.com.br.html');

		$client = new \PragmaRX\Sdk\Services\Scraper\GoutteClient();

		$scraper = new \PragmaRX\Sdk\Services\Scraper\Service($client, $this->rules, $this->data);

		$urls = $scraper->getAllUrls();

		$scraper->setUrl('http://development.imobiliar.io/zap.com.br.html');
		$this->setUrl('http://development.imobiliar.io/zap.com.br.html');

	//	dd( $crawler->filter('div .result-ofertas')->html() );

		$links = [];

//		foreach($this->getClient()->request('http://development.imobiliar.io/zap.com.br.html')->filter($this->rules['links'])->links() as $link)
//		{
//			$links[] = $link->getUri();
//		}
//		dd($links);
//

		foreach($this->filter($this->rules['links'])->links() as $link)
		{
			$links[] = $link->getUri();
		}
		dd($links);














		$links = [];

		$goutte = new \Goutte\Client();

		$crawler = $goutte->request('GET', 'http://development.imobiliar.io/zap.com.br.html');

		foreach($this->generateUrls() as $url)
		{
			$this->setUrl('http://development.imobiliar.io/zap.com.br.html');

			$lastPage = false;

			dd($crawler->filter($this->rules['links'])->html());
			while( ! $lastPage)
			{
				foreach ($crawler->filter($this->rules['links'])->links() as $link)
				{
					d($link->getUri());
					$links[] = $link->getUri();
				}

//				$this->nextPage();

				$lastPage = true;
			}
		}

		return $links;
	}

	/**
	 * Parse the rules into some needed private variables.
	 *
	 */
	private function parseRules()
	{
		if (isset($this->rules['url']))
		{
			$this->url = $this->rules['url'];
		}
	}

	/**
	 * Generate urls to be scraped.
	 *
	 * @return array
	 */
	public function generateUrls()
    {
	    return array_strings_generator($this->data, $this->url);
    }

	/**
	 * Get a list of all urls to be scraped.
	 *
	 * @return array
	 */
	public function getAllUrls()
	{
		$urls = [];

		foreach($this->generateUrls() as $url)
		{
			$urls[] = $url;
		}

		return $urls;
	}

	/**
	 * Get the data array.
	 *
	 * @return null
	 */
	public function getData()
    {
        return $this->data;
    }

    public function scrape($argument1)
    {
        // TODO: write logic here
    }

	public function links()
	{
		return $this->crawler()->links();
	}
}
