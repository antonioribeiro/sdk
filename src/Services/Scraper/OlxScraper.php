<?php

namespace PragmaRX\Sdk\Services\Scraper;


class OlxScraper extends BaseScraper {

	protected $webserviceName = 'Zap';

	protected $rules = [
		'result' => 'links',
//        'url' => 'http://%state%.olx.com.br/%district%/%region%',

		'url' => 'http://local.crm.com/olx-saogoncalo.html',

//		'url' => 'http://www.zap.com.br/imoveis/%city%/%unit-type%/%sell-rent%/',
//		'url' => 'http://development.imobiliar.io/zap.com.br.html',


//		 Estácio
//		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro+estacio/apartamento-padrao/?ord=dataatualizacao&rn=1157655291',

//		 Tijuca
//		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro/apartamento-padrao/?ord=dataatualizacao&rn=1157655291&pag=1',

	    'links' => '#main-ad-list > li > a',
        'next.page.link' => 'a[rel="next"]',
	];

	protected $data = [
	    '%state%' => ['rj'],
        '%district%' => ['rio-de-janeiro-e-regiao'],
        '%region%' => ['sao-goncalo'],


		'%city%' => ['rio-de-janeiro'],
	    '%unit-type%' => ['apartamento-padrao'],
	    '%sell-rent%' => ['venda','aluguel'],
	];

	public function getLinks()
	{
		$links = [];

		$count = 0;

		foreach($this->generateUrls() as $url)
		{
			$this->setUrl($url);

			while($this->hasContent && $count <= 0)
			{
				foreach($this->links() as $link)
				{
					$links[$link['webservice_url_code']] = $link;
				}

				$this->nextPage();

				$count++;
			}
		}

		return $links;
	}

	public function scrapeLink($link)
	{
		preg_match("/\/(.*)/", $link, $parts);

		return [
			'url' => $link,
			'webservice_url_code' => $parts[1],
		];
	}

    public function scrapeData($link)
    {
        $linkCrawler = $this->setUrl($url = $link['url']);

        while ($this->hasContent)
        {
            $data = [
                'url' => $url,
                'name' => $linkCrawler->filter('.item.owner > p')->text(),
                'description' => $linkCrawler->filter('title')->text(),
                'phone' => $linkCrawler->filter('img.number[alt="número do telefone"]')->attr('src'),
            ];

            dd($linkCrawler->filter('.item.owner > p')->text());

            dd($this->getCrawler()->html());
        }
    }
}
