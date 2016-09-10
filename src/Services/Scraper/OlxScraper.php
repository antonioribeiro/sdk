<?php

namespace PragmaRX\Sdk\Services\Scraper;

use Baum\Extensions\Eloquent\Collection;
use Imagick;
use Storage;
use Illuminate\Support\Str;
use App\Data\Repositories\Olx;
use PragmaRX\Sdk\Services\Ocr\Service\Ocr;

class OlxScraper extends BaseScraper
{
	protected $webserviceName = 'Zap';

	protected $rules = [
		'result' => 'links',
        'url' => 'http://%state%.olx.com.br/%district%/%region%',

//		'url' => 'http://local.crm.com/olx-saogoncalo.html',

//		'url' => 'http://www.zap.com.br/imoveis/%city%/%unit-type%/%sell-rent%/',
//		'url' => 'http://development.imobiliar.io/zap.com.br.html',


//		 Estácio
//		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro+estacio/apartamento-padrao/?ord=dataatualizacao&rn=1157655291',

//		 Tijuca
//		'url' => 'http://www.zap.com.br/imoveis/rio-de-janeiro+rio-de-janeiro/apartamento-padrao/?ord=dataatualizacao&rn=1157655291&pag=1',

	    'links' => '#main-ad-list > li > a',

        'next.page.query' => '?o=%page%',
	];

	protected $data = [
	    '%state%' => ['rj'],
        '%district%' => ['rio-de-janeiro-e-regiao'],
        '%region%' => ['zona-sul'],

		'%city%' => ['rio-de-janeiro'],
	    '%unit-type%' => ['apartamento-padrao'],
	    '%sell-rent%' => ['venda','aluguel'],
	];

    /**
     * @var \App\Data\Repositories\Olx
     */
    private $repository;

    public function __construct()
    {
        $this->repository = $repository = app(Olx::class);

        parent::__construct();
    }

    private function addAreaCode($phone)
    {
        $areacode = '21';
        $number = $phone;

        if (strlen($phone) > 9)
        {
            list($areacode, $number) = $this->extractAreaCode($phone);

            if (! $areacode)
            {
                $areacode = '21';
            }
        }

        return $areacode.$number;
    }

    private function addLinkToDatabase($link)
    {
        if (! $this->repository->findByUrl($url = $link['url']))
        {
            return $this->repository->create(['url' => $url]);
        }
    }

    private function clearString($string)
    {
        return trim(str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string));
    }

    private function extractAreaCode($phone)
    {
        $areas = [
            '21',
            '22',
            '23',
            '24'
        ];

        foreach ($areas as $area) {
            $extracted = '';

            if (starts_with($phone, $area))
            {
                $extracted = $area;
            }

            if (starts_with($phone, '0'.$area))
            {
                $extracted = '0'.$area;
            }

            if ($extracted)
            {
                return [$extracted, (int) substr($phone, strlen($extracted))];
            }
        }

        return ['', $phone];
    }

    private function extractCategory($items)
    {
        if ($items)
        {
            return isset($items['categoria'])
                ? isset($items['categoria'])
                : (isset($items['tipo']) ? $items['tipo'] : '');
        }
    }

    private function extractItems($string, $linkCrawler)
    {
        $items = $linkCrawler->filter($string)->each(function ($node)
        {
            $type = $this->getNodeText($node, 'span');
            $data = $this->getNodeText($node, 'strong');

            return [strtolower(str_replace(':', '', $type)) => $data];
        });

        $result = [];

        foreach ($items as $item)
        {
            $key = trim(key($item));

            $value = $this->clearString($item[key($item)]);

            if ($key && $value)
            {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private function extractNotes($filter)
    {
        if (! $filter->count())
        {
            return null;
        }

        return $this->clearString($filter->text());
    }

    private function extractPhone($filter)
    {
        if ($filter->count())
        {
            return $this->ocr($filter->attr('src'));
        }

        return ['',''];
    }

    private function extractPhonesFromNotes($notes)
    {
        if (! $notes)
        {
            return [];
        }

        $regex = '/(\d|\+|\()(\+|\d|\(|\)|-| |\/){7,}(\d|\))+\b/';

        preg_match_all($regex, $notes, $matches);

        $result = [];

        foreach ($matches as $match)
        {
            if (isset($match[0]) && strlen($match[0]) >= 8)
            {
                $result[] = $match[0];
            }
        }

        return $result;
    }

    public function getLinks($command, $pageCount = 0)
	{
		$links = [];

        $linkCount = 0;
        $linkFound = 0;

		foreach($this->generateUrls() as $url)
		{
			$this->setUrl($url);

			while($this->hasContent)
			{
				foreach($this->links() as $link)
				{
                    if ($this->addLinkToDatabase($link))
                    {
                        $links[$link['webservice_url_code']] = $link;
                        $linkCount++;
                    }
                    else
                    {
                        $linkFound++;
                    }
				}

                $pageCount++;

                $this->log($command, "Getting links from page $pageCount. Total link count: ".$linkCount." - Links already downloaded: ".$linkFound);

				$this->nextPage($url, $pageCount);
			}
		}

		return $links;
	}

    /**
     * @param $counter
     * @param $data
     * @return string
     */
    private function getLogLine($counter, $data)
    {
        return sprintf("%s: %s - %s", str_pad($counter, 6, '0', STR_PAD_LEFT), $data['phone'], $data['name']);
    }

    private function getNodeText($node, $string)
    {
        $node = $node->filter($string);

        if (! $node->count())
        {
            return '';
        }

        return $node->text();
    }

    private function keepOnlyNumbers($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }

    /**
     * @param $command
     * @param $counter
     * @param $data
     */
    private function logLine($command, $counter, $data)
    {
        $this->log($command, $this->getLogLine($counter, $data));
    }

    private function normalizeName($name)
    {
        $name = strtolower($name);
        $normalized = array();

        $name = preg_replace(['/_/', '/-/', '/\./'], ' ', $name);

        foreach (preg_split('/([^a-z])/', $name, NULL, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) as $word) {
            if (preg_match('/^(mc)(.*)$/', $word, $matches)) {
                $word = $matches[1] . ucfirst($matches[2]);
            }

            $normalized[] = ucfirst($word);
        }

        return implode('', $normalized);
    }

    private function ocr($url)
    {
        $file = Str::random().'.gif';

        Storage::drive($disk = 'local')->put($file, file_get_contents('http:'.$url));

        $gifFile = Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file);
        $tiffFile = Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file);

        $im = new Imagick($tiffFile);

        $tiffFile = str_replace('.gif', '.tiff', $tiffFile);

        $im->setCompression(Imagick::COMPRESSION_NO);
        $im->setImageBackgroundColor('white');
        $im->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $im->setImageCompressionQuality(100);

        $im->writeImage($tiffFile);

        $text = Ocr::run($tiffFile);

        unlink($gifFile);
        unlink($tiffFile);

        return [$text, $url];
    }

    public function scrapeLink($link)
	{
		preg_match("/\/(.*)/", $link, $parts);

		return [
			'url' => $link,
			'webservice_url_code' => $parts[1],
		];
	}

    public function scrapeData($link, $scrapePhone = true)
    {
        if (is_array($link))
        {
            $link = $link['url'];
        }

        $linkCrawler = $this->setUrl($link);

        $phone = '';
        $urlPhone = '';

        if ($this->hasContent && $linkCrawler->getUri() == $link)
        {
            if ($scrapePhone)
            {
                list($phone, $urlPhone) = $this->extractPhone($linkCrawler->filter('img.number[alt="número do telefone"]'));
            }

            $items = $this->extractItems('li.item > p.text', $linkCrawler);

            $category = $this->extractCategory($items);

            $notes = $this->extractNotes($linkCrawler->filter('div.OLXad-description > p.text'));
            $phones = $this->extractPhonesFromNotes($notes);

            if ($phone)
            {
                $phones[] = $phone;
            }

            $data = [
                'url' => $link,
                'name' => $linkCrawler->filter('.item.owner > p')->text(),
                'description' => $linkCrawler->filter('title')->text(),
                'notes' => $notes,
                'neighbourhood' => isset($items['bairro']) ? $items['bairro'] : null,
                'city' => isset($items['município']) ? $items['município'] : null,
                'category' => $category,
                'postalcode' => isset($items['cep']) ? $items['cep'] : null,
                'phone' => join(',', $phones),
                'url_phone' => $urlPhone,
            ];

            return $data;
        }
    }

    public function scrape($command = null, $pageStart = 0)
    {
        $counter = 0;

        foreach ($this->getLinks($command, $pageStart) as $link) {
            if (!$this->repository->findByUrl($link['url']) && $data = $this->scrapeData($link))
            {
                $counter++;

                $this->logLine($command, $counter, $data);

                $this->repository->create($data);
            }
        }
    }

    public function scrapeUrls($command = null, $order = 'asc', $rescrape = false)
    {
        $rescrape = $rescrape && (strtolower($rescrape) == 'yes' || strtolower($rescrape) == 'true');

        $counter = 0;

        foreach ($this->repository->getAllNotScraped($order, $rescrape) as $row)
        {
            $counter++;

            if ($row->scraped && ! $rescrape)
            {
                $this->log($command, 'Skipping already scraped.');

                continue;
            }

            $data = $this->scrapeData($row->url);

            $this->logLine($command, $counter, $data);

            $data['scraped'] = true;

            $row->update($data);
        }
    }

    public function normalizePhones($command = null)
    {
        $this->log($command, 'name;phone_mobile;primary_address_neighbourhood;primary_address_city;primary_address_postalcode');

        foreach ($this->repository->all() as $row) {
            if (! trim($row->phone))
            {
                continue;
            }

            $phone = preg_split("#[,;/\\\]+#", $row->phone);

            $phones = new Collection($phone);

            $phones = $phones->map(function($value) use ($command, $row, &$counter) {
                $phone = $this->keepOnlyNumbers($value);
                $phone = $this->addAreaCode($phone);

                return $phone;
            });

            $phones = $phones->unique();

            $phones->map(function($phone) use ($row, $command) {
                $name = $this->normalizeName($row->name);
                $log = sprintf(
                    "%s;%s;%s;%s;%s",
                    $name,
                    $phone,
                    $row->neighbourhood,
                    $row->city,
                    $row->postalcode
                );
                $this->log($command, $log);
            });
        }
    }

    public function fillData($console = null)
    {
        $counter1 = 0;
        $counter2 = 0;

        foreach ($this->repository->getAllIncomplete() as $row)
        {
            $counter1++;

            $data = $this->scrapeData($row->url, false);
            $changed = false;

            if ($row->neighbourhood != $data['neighbourhood'])
            {
                $row->neighbourhood = $data['neighbourhood'];
                $changed = true;
            }

            if ($row->city != $data['city'])
            {
                $row->city = $data['city'];
                $changed = true;
            }

            if ($row->postalcode != $data['postalcode'])
            {
                $row->postalcode = $data['postalcode'];
                $changed = true;
            }

            if ($changed)
            {
                $counter2++;

                $log = sprintf(
                    "%s de %s: %s - %s - %s - %s",
                    str_pad($counter2, 6, '0', STR_PAD_LEFT),
                    str_pad($counter1, 6, '0', STR_PAD_LEFT),
                    $row->name,
                    $row->neighbourhood,
                    $row->city,
                    $row->postalcode
                );

                $row->save();
                $this->log($console, $log);
            }
        }
    }
}
