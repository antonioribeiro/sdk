<?php

namespace PragmaRX\Sdk\Services\Scraper;


class ZapScraper extends BaseScraper {

	protected $webserviceName = 'Zap';

	protected $rules = [
		'result' => 'links',
//		'url' => 'http://www.zap.com.br/imoveis/%city%/%unit-type%/%sell-rent%/',
//		'url' => 'http://development.imobiliar.io/zap.com.br.html',


//		 Estácio
//		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro+estacio/apartamento-padrao/?ord=dataatualizacao&rn=1157655291',

//		 Tijuca
		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro/apartamento-padrao/?ord=dataatualizacao&rn=1157655291&pag=1',

	    'links' => 'div .result-ofertas .full a',
	    'next.page.link' => 'div .paginacao .pagNext',
	];

	protected $data = [
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
		preg_match("/\/(ID-.[0-9]+)/", $link, $parts);

		return [
			'url' => $link,
			'webservice_url_code' => $parts[1],
		];
	}
}
