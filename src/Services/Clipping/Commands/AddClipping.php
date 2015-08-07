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

	public function __construct(
						$url,
						$published_at,
						$heading,
						$subheading,
						$body,
						$editorial_id,
						$editorial_other,
						$vehicle_id,
						$vehicle_other,
						$author,
						$locality_id,
						$locality_other,
						$image_main_urls,
						$image_snapshot_urls,
						$image_other_urls,
						$videos,
						$tags
	)
	{
		$this->url = $url;
		$this->published_at = $published_at;
		$this->heading = $heading;
		$this->subheading = $subheading;
		$this->body = $body;
		$this->editorial_id = $editorial_id;
		$this->editorial_other = $editorial_other;
		$this->vehicle_id = $vehicle_id;
		$this->vehicle_other = $vehicle_other;
		$this->author = $author;
		$this->locality_id = $locality_id;
		$this->locality_other = $locality_other;
		$this->image_main_urls = $image_main_urls;
		$this->image_snapshot_urls = $image_snapshot_urls;
		$this->image_other_urls = $image_other_urls;
		$this->videos = $videos;
		$this->tags = $tags;
	}

	public function handle(ClippingRepository $clippingRepository)
	{
		$this->dispatchEventsFor(
			$result = $clippingRepository->add($this->getPublicProperties())
		);

		return $result;
	}

}
