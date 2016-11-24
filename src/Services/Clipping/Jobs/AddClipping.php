<?php

namespace PragmaRX\Sdk\Services\Clipping\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Clipping\Data\Repositories\Clipping as ClippingRepository;

class AddClipping extends Job
{
	public $url;

	public $published_at;

	public $heading;

	public $subheading;

	public $body;

	public $editorial_id;

	public $editorial_other;

	public $vehicle_id;

	public $vehicle_other;

	public $author;

	public $locality_id;

	public $locality_other;

	public $image_main_urls;

	public $image_snapshot_urls;

	public $image_other_urls;

	public $videos;

	public $tags;

	public function handle(ClippingRepository $clippingRepository)
	{
		return $clippingRepository->add($this->getPublicProperties());
	}
}
