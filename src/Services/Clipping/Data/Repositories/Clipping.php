<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Repositories;

use Carbon\Carbon;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\Clipping as Model;

use PragmaRX\Sdk\Services\Clipping\Data\Entities\Clipping as ClippingArticle;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingAuthor;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingCategory;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingFile;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingFileType;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingLocality;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingVehicle;

class Clipping
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}

	public function findPostById($id)
	{
		return Model::findOrFail($id);
	}

	public function add($article)
	{
		$publishedAt = Carbon::createFromFormat('m/d/Y', $article['published_at']);

		$authorId = ClippingAuthor::firstOrCreate(['name' => $article['author']]);

		if ( ! $vehicleId = $article['vehicle_id'])
		{
			$vehicleId = ClippingVehicle::firstOrCreate(['name' => $article['vehicle_other']])->id;
		}

		if ( ! $categoryId = $article['category_id'])
		{
			$categoryId = ClippingCategory::firstOrCreate(['name' => $article['category_other']])->id;
		}

		if ( ! $localityId = $article['locality_id'])
		{
			$localityId = ClippingLocality::firstOrCreate(['name' => $article['locality_other']]);
		}

		$clipping = ClippingArticle::create(
			[
				'heading' => $article['heading'],
				'subheading' => $article['subheading'],
				'body' => $article['body'],
				'author_id' => $authorId,
				'vehicle_id' => $vehicleId,
				'category_id' => $categoryId,
				'locality_id' => $localityId,
				'url' => $article['url'],
				'article_preview_url' => $article['image_snapshot_urls'],
				'published_at' => $publishedAt,
			]
		);

		$this->createImages($clipping->id, $article['image_main_urls'], true); // main
		$this->createImages($clipping->id, $article['image_snapshot_urls'], false, true); // snapshot
		$this->createImages($clipping->id, $article['image_other_urls']); // other images

		return $clipping;
	}

	private function createImages($clippingId, $urls, $main = false, $snapshot = false)
	{
		$clippingFile = app()->make(ClippingFile::class);

		foreach ($urls as $url)
		{
			$clippingFile->createFor(
				$clippingId,
				$main,
				$snapshot,
				$url,
				ClippingFileType::firstorCreate(['name' => 'image'])
			);
		}
	}
}
