<?php

namespace PragmaRX\Sdk\Services\Scraper;

use App\Data\Entities\OlxNeighbourhood;
use App\Support\Accent;
use Baum\Extensions\Eloquent\Collection;
use Imagick;
use PragmaRX\Support\Timer;
use Storage;
use Illuminate\Support\Str;
use App\Data\Repositories\Olx;
use PragmaRX\Sdk\Services\Ocr\Service\Ocr;
use Exception;
use Throwable;

class OlxScraper extends BaseScraper
{
	protected $webserviceName = 'Zap';

	protected $rules = [
		'result' => 'links',

        'url' => 'http://%state%.olx.com.br/%region%/%subregion%/%city_or_neighbourhood',

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

        '%zone%' => ['rio-de-janeiro-e-regiao'],

        '%region%' => ['sao-goncalo'],

		'%city%' => ['rio-de-janeiro'],

	    '%unit-type%' => ['apartamento-padrao'],

	    '%sell-rent%' => ['venda','aluguel'],
	];

	protected $states = [
        'sp',
        'rj',
        'mg',
        'se',
        'to',
        'ac',
        'al',
        'ap',
        'am',
        'ba',
        'ce',
        'df',
        'es',
        'go',
        'ma',
        'mt',
        'ms',
        'pa',
        'pb',
        'pr',
        'pe',
        'pi',
        'rn',
        'rs',
        'ro',
        'rr',
        'sc',
    ];

    /**
     * @var \App\Data\Repositories\Olx
     */
    protected $repository;

    public function __construct()
    {
        $this->repository = $repository = app(Olx::class);

        parent::__construct();
    }

    protected function _ocr($url, $command, $prefix)
    {
        $file = $prefix.Str::random().'.gif';
        echo "$file\n";

        Storage::drive($disk = 'ocr')->put($file, file_get_contents($url));

        $gifFile = Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file);
        $tiffFile = str_replace('.gif', '.tiff', $gifFile);

//        $exec = 'convert '.$gifFile.' -alpha off -compress none '.$tiffFile.' 2>/dev/null';
//        echo $exec."/n";
//        exec($exec);

        $im = new Imagick($gifFile);

        $im->setCompression(Imagick::COMPRESSION_NO);
        $im->setImageBackgroundColor('white');
        $im->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $im->setImageCompressionQuality(100);

        $im->writeImage($tiffFile);

        $text = Ocr::run($tiffFile);

        @unlink($gifFile);
        @unlink($tiffFile);

        return [$text, $url];
    }

    protected function addAreaCode($phone)
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

    protected function addLinkToDatabase($link)
    {
        if (! $this->repository->findByUrl($url = $link['url']))
        {
            return $this->repository->create([
                'url' => $url,
                'state_code' => $this->extractStateCodeFromOlxUrl($url),
                'zone' => $this->data['%zone%'][0],
                'region' => $this->data['%region%'][0],
            ]);
        }
    }

    public function extractStateCodeFromOlxUrl($url)
    {
        preg_match('|https://(.*)\.olx|', $url, $matches);

        if (isset($matches[1])) {
            return upper($matches[1]);
        }

        return null;
    }

    protected function clearString($string)
    {
        return trim(str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string));
    }

    protected function extractAreaCode($phone)
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

    protected function extractCategory($items)
    {
        if ($items)
        {
            return isset($items['categoria'])
                ? isset($items['categoria'])
                : (isset($items['tipo']) ? $items['tipo'] : '');
        }
    }

    protected function extractItems($string, $linkCrawler)
    {
        $items = $linkCrawler->filter($string)->each(function ($node)
        {
            $type = $this->getNodeText($node, 'span');
            $data = $this->getNodeText($node, 'strong');

            return [strtolower(str_replace(':', '', Accent::remove($type))) => $data];
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

    protected function extractNotes($filter)
    {
        if (! $filter->count())
        {
            return null;
        }

        return $this->clearString($filter->text());
    }

    protected function extractPhone($filter)
    {
        if ($filter->count())
        {
            return $this->ocr($filter->attr('src'));
        }

        return ['',''];
    }

    protected function extractPhonesFromNotes($notes)
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
                $result[] = $this->cleanPhone($match[0]);
            }
        }

        return $result;
    }

    public function getLinks($command, $pageCount = 0)
	{
		$links = [];

        $linkCount = 0;
        $linkFound = 0;
        $linkAlreadyAdded = 0;
        $pageAlreadyAdded = 0;

        foreach($this->generateUrls() as $url)
		{
		    $command->info('scraping '.$url);

			$crawler = $this->setUrl($url);

			if ($crawler === static::ERROR_CONNECTION_IS_DOWN) {
                $this->log($command, 'Connection is down. Exiting...');
                die;
            }

            while($this->hasContent)
			{
				foreach($this->links() as $link)
				{
                    if ($this->addLinkToDatabase($link))
                    {
                        $links[$link['webservice_url_code']] = $link;
                        $linkCount++;
                        $linkAlreadyAdded = 0;
                        $pageAlreadyAdded = 0;
                    }
                    else
                    {
                        $linkFound++;
                        $linkAlreadyAdded++;
                    }
				}

                $pageCount++;
                $pageAlreadyAdded++;

                $this->log($command, "Getting links from page $pageCount. New links found: ".$linkCount." - Already in database: ".$linkFound." - ".$linkAlreadyAdded." - ".$pageAlreadyAdded);

                if ($pageCount > 100 || $linkAlreadyAdded > 170 || $pageAlreadyAdded > 4) {
                    $pageCount = 0;

                    $linkAlreadyAdded = 0;

                    $pageAlreadyAdded = 0;

				    break;
                }

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
    protected function getLogLine($counter, $data, $link = null)
    {
        return sprintf("%s: %s - %s | %s | %s", str_pad($counter, 6, '0', STR_PAD_LEFT), $data['phone'], $data['name'], $link, $data['url']);
    }

    /**
     * @param $items
     * @return null
     */
    protected function getMunicipioFromItems($items)
    {
        $columnName = isset($items['município']) ? 'município' : (isset($items['municã­pio']) ? 'municã­pio' : 'municipio');

        return isset($items[$columnName]) ? $items[$columnName] : null;
    }

    protected function getNodeText($node, $string)
    {
        $node = $node->filter($string);

        if (! $node->count())
        {
            return '';
        }

        return $node->text();
    }

    protected function keepOnlyNumbers($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }

    /**
     * @param $command
     * @param $counter
     * @param $data
     */
    protected function logLine($command, $counter, $data, $link = null)
    {
        $this->log($command, $this->getLogLine($counter, $data, $link));
    }

    protected function normalizeName($name)
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

    protected function ocr($url, $command = null, $prefix = '')
    {
        $errors = 0;

        while ($errors < 3)
        {
            try
            {
                return $this->_ocr($url, $command, $prefix);
            }
            catch (Exception $exception)
            {
                $errors++;
            }
        }
    }

    protected function sanitizeForCsv($string)
    {
        return str_replace(';', '.', $string);
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

        if (is_string($linkCrawler) || $link !== $linkCrawler->getUri()) {
            return is_string($linkCrawler) ? $linkCrawler : static::ERROR_NOT_FOUND;
        }

        if ($linkCrawler->filter('.OLXad-title')->count() == 0) {
            return static::ERROR_NOT_FOUND;
        }

        $phone = '';
        $urlPhone = '';

        if ($this->hasContent && $linkCrawler->getUri() == $link)
        {
            if ($scrapePhone)
            {
                list($phone, $urlPhone) = $this->extractPhone($linkCrawler->filter('img.number[alt="número do telefone"]'));
            }

            $items = $this->extractItems('li.item > p.text', $linkCrawler);
            
            $items = collect($items)->mapWithKeys(function ($item, $key) {
                return [Accent::remove($key) => $item];
            });

            $category = $this->extractCategory($items);

            $notes = $this->extractNotes($linkCrawler->filter('div.OLXad-description > p.text'));

            $phones = $this->extractPhonesFromNotes($notes);

            $data = [
                'url' => $link,
                'name' => $linkCrawler->filter('.item.owner > p')->text(),
                'description' => $linkCrawler->filter('title')->text(),
                'notes' => $notes,
                'neighbourhood' => isset($items['bairro']) ? $items['bairro'] : null,
                'city' => $this->getMunicipioFromItems($items),
                'category' => $category,
                'postalcode' => isset($items['cep']) ? $items['cep'] : null,
                'phone' => $this->cleanPhone($phone),
                'other_phones' => join(',', $phones),
                'url_phone' => $urlPhone,
            ];

            return $data;
        }
    }

    protected function cleanPhone($phone)
    {
        return preg_replace('/[^0-9.]+/', '', $phone);
    }

    public function scrape($command = null, $pageStart = 0)
    {
        $counter = 0;

        foreach ($this->getLinks($command, $pageStart) as $link) {
            if (!$this->repository->findByUrl($link['url']) && $data = $this->scrapeData($link))
            {
                $counter++;

                $this->logLine($command, $counter, $data, $link);

                $this->repository->create($data);
            }
        }
    }

    public function getTextFromNode($Node, $Text = "") {
        if ($Node->tagName == null)
            return $Text.$Node->textContent;

        $Node = $Node->firstChild;
        if ($Node != null)
            $Text = $this->getTextFromNode($Node, $Text);

        while($Node->nextSibling != null) {
            $Text = $this->getTextFromNode($Node->nextSibling, $Text);
            $Node = $Node->nextSibling;
        }
        return $Text;
    }

    public function getUriLastPart($uri)
    {
        $parts = explode('/', $uri);

        return $parts[count($parts)-1];
    }

    public function makeCrawlerUrl($state, $region = null, $zone = null, $neighbourhood_slug = null)
    {
        $url = "https://{$state}.olx.com.br/";

        if ($region) {
            $url .= "{$region}/";
        }

        if ($zone) {
            $url .= "{$zone}/";
        }

        if ($neighbourhood_slug) {
            $url .= "{$neighbourhood_slug}/";
        }

        return $url;
    }

    public function scrapeStateRegions()
    {
        $states = $this->getAllStates()->map(function ($state) {
            OlxNeighbourhood::where('state_code', $state)->delete();

            return coollect($this->setUrl("https://{$state}.olx.com.br/")->filter('.linkshelf-tabs-content.state')->filter('a')->links())->map(function ($link) use ($state)
            {
                return coollect([
                    'state_code' => $state,
                    'region_url' => $uri = $link->getUri(),
                    'region_code' => $this->getUriLastPart($uri),
                    'region_name' => $link->getNode()->getAttribute('title')
                ]);
            });
        });

        return $states->flatten(1);
    }

    public function scrapeRegionZones($region)
    {
        return coollect($this->setUrl($this->makeCrawlerUrl($region->state_code,
            $region->region_code))->filter('div.linkshelf-tabs-content.zones')->filter('ul')->filter('a')->links())->reject(function (
            $link
        ) {
            return !starts_with($link->getUri(), 'https:');
        })->map(function ($link) use ($region) {
            return coollect(
                [
                    'zone_url' => $uri = $link->getUri(),
                    'zone_code' => $this->getUriLastPart($uri),
                    'zone_name' => $link->getNode()->getAttribute('title')
                ]
            );
        });
    }

    public function scrapeZoneCities($region, $zone)
    {
        $crawler = $this->setUrl($this->makeCrawlerUrl($region->state_code, $region->region_code, $zone['zone_code']));

        $labels = coollect($crawler->filter('.linkshelf-tabs-content.neighbourhood')->filter('label')->extract(['_text']))->map(function ($label) {
            preg_match('|(.*),|', $label, $matches);

            return trim($matches[1]);
        });

        $ids = coollect($crawler->filter('.linkshelf-tabs-content.neighbourhood')->filter('input')->extract(['value']))->reject(function ($value) {
            return !is_numeric($value);
        })->map(function ($item, $index) use ($labels, $region, $zone) {
            $slug = $this->makeSlug($labels[$index]);

            return [
                'neighbourhood_code' => $item,
                'neighbourhood_name' => $labels[$index],
                'neighbourhood_url' => $this->makeCrawlerUrl($region->state_code, $region->region_code, $zone['zone_code'], $slug),
                'neighbourhood_slug' => $slug,
            ];
        })->each(function ($neighbourhood) use ($region, $zone) {
            $this->createOlxNeighbourhood($region, $zone, $neighbourhood);
        });

        return $ids;
    }

    public function makeSlug($string)
    {
        $slug = trim(strtolower(Accent::remove($string)));

        return str_replace(' ', '-', $slug);
    }

    public function createOlxNeighbourhood($region, $zone, $neighbourhood)
    {
        OlxNeighbourhood::create([
            'state_code' => $region['state_code'],
            'region_url' => $region['region_url'],
            'region_code' => $region['region_code'],
            'region_name' => $region['region_name'],
            'zone_url' => $zone['zone_url'],
            'zone_code' => $zone['zone_code'],
            'zone_name' => $zone['zone_name'],
            'neighbourhood_url' => $neighbourhood['neighbourhood_url'],
            'neighbourhood_code' => $neighbourhood['neighbourhood_code'],
            'neighbourhood_name' => $neighbourhood['neighbourhood_name'],
            'neighbourhood_slug' => $neighbourhood['neighbourhood_slug'],
        ]);
    }

    public function scrapeStates($command = null, $pageStart = 0)
    {
        $states = $this->scrapeStateRegions()->map(function ($region) use ($command) {
            $command->info($region["state_code"] . ' - ' .    $region["region_url"] . ' - ' .    $region["region_code"] . ' - ' .    $region["region_name"]);

            $region['zones'] = $this->scrapeRegionZones($region)->map(function ($zone) use ($region) {
                $zone['cities'] = $this->scrapeZoneCities($region, $zone);

                return $zone;
            });

            return $region;
        });

        $command->info(OlxNeighbourhood::count().' neighbourhoods generated');
    }

    public function scrapeUrls($command = null, $order = 'asc', $rescrape = false)
    {
        $rescrape = $rescrape && ($rescrape === true || strtolower($rescrape) == 'yes' || strtolower($rescrape) == 'true');

        $counter = 0;

        $timeout = 0;

        while (true) {
            $row = $this->repository->getAllNotScraped($order, $rescrape);

            if (is_null($row)) {
                break;
            }

            $counter++;

            Timer::start();

            $command->info('----------------------------------------------------------------------------');
            $command->info($row->url);

            if ($row->scraped && ! $rescrape)
            {
                $this->log($command, 'Skipping already scraped.');

                continue;
            }

            try {
                if (! $data = $this->scrapeData($row->url))
                {
                    continue;
                }
            } catch (\Exception $exception) {
                $data = static::ERROR_NOT_FOUND;
            }

            if ($data === static::ERROR_CONNECTION_IS_DOWN) {
                $this->log($command, 'Looks like the internet connection is down. Exiting...');
                die;
            }

            if ($data === static::ERROR_NOT_FOUND) {
                $this->log($command, 'Not found, removing from next runs...');

                $row->not_found = true;

                $row->save();

                continue;
            }

            $this->logLine($command, $counter, $data);

            $data['scraped'] = true;
            $data['ocr_done'] = true;

            $row->update($data);

            $command->info("Elapsed: ".Timer::elapsed());

            if (Timer::elapsed() > 0.6) {
                $timeout++;

                if ($timeout > 10) {
                    $command->info("It's taking too long! Dying...");
                    die();
                }
            } else {
                if (Timer::elapsed() <= 0.45) {
                    $timeout = 0;
                }
            }
        }
    }

    public function normalizePhones($command = null, $columns = '*', $filter = '')
    {
        if ($columns == '*')
        {
            $columns = 'name;phone_mobile;phone_home;phone_other;primary_address_neighbourhood;primary_address_city;primary_address_postalcode;zone;region';
        }

        $columns = explode(';', $columns);

        $this->log($command, implode(';', $columns));

        foreach ($this->repository->filterWith($filter) as $row) {
            if (! trim($row->phone))
            {
                continue;
            }

            $phone = preg_split($regex = "#[,;/\\\]+#", $row->phone);

            $phones = new Collection($phone);

            foreach(preg_split($regex, $row->other_phones) as $phone)
            {
                if (! empty($phone))
                {
                    $phones->push($phone);
                }
            }

            $phones = $phones->map(function($value) use ($command, $row, &$counter) {
                $phone = $this->keepOnlyNumbers($value);
                $phone = $this->addAreaCode($phone);

                if (strlen($phone) <= 8)
                {
                    return null;
                }

                return $phone;
            });

            try {
                $phones = $phones->unique();
            }
            catch (\Exception $e)
            {
                $phones = new Collection();
            }
            catch (Throwable $e)
            {
                $phones = new Collection();
            }

            $phones->map(function($phone) use ($row, $command, $columns) {
                $name = $this->normalizeName($row->name);

                list($mobile, $home, $other) = $this->selectPhone($phone);

                $data['name'] = $name;
                $data['phone_mobile'] = $mobile;
                $data['phone_home'] = $home;
                $data['phone_other'] = $other;
                $data['primary_address_neighbourhood'] = $row->neighbourhood;
                $data['primary_address_city'] = $row->city;
                $data['primary_address_postalcode'] = $row->postalcode;
                $data['zone'] = $row->zone;
                $data['region'] = $row->region;

                if($mobile || $home || $other)
                {
                    $data = array_only($data, $columns);

                    $log = '"'.implode('";"', $data).'"';

                    $this->log($command, $log);
                }
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

    public function selectPhone($phone)
    {
        $mobile = null;
        $home = null;
        $other = null;

        if (strlen($phone) < 10 || strlen($phone) > 11)
        {
            $other = $phone;
        }
        elseif (strlen($phone) == 10)
        {
            $home = $phone;
        }
        else
        {
            $mobile = $phone;
        }

        return [$mobile, $home, $other];
    }

    public function executeOcr($command = null)
    {
        $counter = 0;

        foreach ($this->repository->withoutOcr() as $row) {
            if (! $row->url_phone)
            {
                continue;
            }

            $prefix = str_pad($counter++, 6, '0', STR_PAD_LEFT);

            list($phone, $url) = $this->ocr($row->url_phone, $command, $prefix.'-');

            $log = $prefix . " - {$row->name} - {$phone}";

            if ($phone != $row->phone)
            {
                $row->phone = $phone;
                $row->other_phones = join(',', $this->extractPhonesFromNotes($row->notes));
                $log .= ' - NEW';
            }

            $row->ocr_done = true;
            $row->save();

            $this->log($command, $log);
        }
    }

    public function getStates()
    {
        return coollect([
            'state' => [[
                'code' => 'rj',

                'name' => 'Rio de Janeiro',

                'region' => [
                    [
                        'code' => 'rio-de-janeiro-e-regiao',
                        'name' => 'Rio de Janeiro e região',
                        'area-code' => '21',
                        'sub_zones' => [
                            'sao_goncalo' => [
                                'code' => 'sao_goncalo',
                                'name' => 'São Gonçalo',
                                'cities_and_neighbourhoods' => [
                                    [ 'code' => '2207', 'name' => '7 Pontes' ],
                                    [ 'code' => '2191', 'name' => 'Alcântara' ],
                                    [ 'code' => '2206', 'name' => 'Arsenal' ],
                                    [ 'code' => '2197', 'name' => 'Bandeirantes' ],
                                    [ 'code' => '2210', 'name' => 'Barreto' ],
                                    [ 'code' => '2214', 'name' => 'Barro Vermelho' ],
                                    [ 'code' => '2192', 'name' => 'Boaçu' ],
                                    [ 'code' => '2193', 'name' => 'Centro' ],
                                    [ 'code' => '2203', 'name' => 'Colubande' ],
                                    [ 'code' => '2202', 'name' => 'Estrela do Norte' ],
                                    [ 'code' => '2190', 'name' => 'Jardim Catarina' ],
                                    [ 'code' => '2198', 'name' => 'Maria Paula' ],
                                    [ 'code' => '2201', 'name' => 'Mutondo' ],
                                    [ 'code' => '2213', 'name' => 'Mutuá' ],
                                    [ 'code' => '2215', 'name' => 'Neves' ],
                                    [ 'code' => '2211', 'name' => 'Nova Cidade' ],
                                    [ 'code' => '2212', 'name' => 'Pacheco' ],
                                    [ 'code' => '2205', 'name' => 'Paraíso' ],
                                    [ 'code' => '2199', 'name' => 'Pita' ],
                                    [ 'code' => '2200', 'name' => 'Porto da Pedra' ],
                                    [ 'code' => '2208', 'name' => 'Porto do Rosa' ],
                                    [ 'code' => '2209', 'name' => 'Porto Novo' ],
                                    [ 'code' => '2189', 'name' => 'Rio do Ouro' ],
                                    [ 'code' => '2196', 'name' => 'Rocha' ],
                                    [ 'code' => '2194', 'name' => 'Santa Catarina' ],
                                    [ 'code' => '2195', 'name' => 'Vista Alegre' ],
                                    [ 'code' => '2204', 'name' => 'Zé Garoto' ],
                                ]
                            ]
                        ]
                    ],
                    [
                        'code' => 'serra-angra-dos-reis-e-regiao',
                        'name' => 'Serra, Angra dos Reis e região',
                        'area-code' => '24'
                    ],
                    [
                        'code' => 'norte-do-estado-do-rio',
                        'name' => 'Norte do Estado e Região dos Lagos',
                        'area-code' => '22'
                    ]
                ]
            ],
        ]]);
    }

    public function getAllStates()
    {
        return coollect($this->states);
    }
}

