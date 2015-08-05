<?php

namespace PragmaRX\Sdk\Services\Clipping\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Clipping\Data\Repositories\Clipping as ClippingRepository;

class AddClipping extends SelfHandlingCommand {

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
		$this->dispatchEventsFor(
			$result = $clippingRepository->add($this->getPublicProperties())
		);

		return $result;
	}

}
