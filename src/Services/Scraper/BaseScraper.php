<?php

namespace PragmaRX\Sdk\Services\Scraper;

use App\Data\Entities\OlxNeighbourhood;
use Cache;
use Goutte\Client as Goutte;
use GuzzleHttp\Client as Guzzle;

abstract class BaseScraper implements ScraperInterface
{
    const ERROR_CONNECTION_IS_DOWN = 'connection is down';

    const ERROR_NOT_FOUND = 'not found';

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
        $this->goutte = $goutte ?: $this->instantiateGoutte();
	}

    public function instantiateGoutte()
    {
        $goutte = new Goutte();

        $goutte->setMaxRedirects(5);

        $guzzle = new Guzzle([
            'timeout' => 30,
            'allow_redirects' => false,
        ]);

        $goutte->setClient($guzzle);

        return $goutte;
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

		try {
            $request = $this->request($url);
        } catch (\GuzzleHttp\Exception\ConnectException $exception) {
            return static::ERROR_CONNECTION_IS_DOWN;
        } catch (\Exception $exception) {
            return static::ERROR_NOT_FOUND;
        } catch (\Symfony\Component\Debug\Exception\FatalThrowableError $exception) {
            return static::ERROR_NOT_FOUND;
        }

        return $request;
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
        // (new Guzzle())->request('GET', $url); // force an exception in case of error

		$this->crawler = $this->goutte->request(
			$method ?: $this->method,
			$url ?: $this->currentUrl,
            ['allow_redirects' => false]
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
        return OlxNeighbourhood::whereIn('state_code', $this->states)
            ->orderBy('state_code')
            ->orderBy('region_name')
            ->get()->sortBy(function ($state) {
                return key(coollect($this->states)->filter(function ($item) use ($state) {
                    return upper($item) === upper($state['state_code']);
                })->toArray());
            })->pluck('neighbourhood_url');
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
