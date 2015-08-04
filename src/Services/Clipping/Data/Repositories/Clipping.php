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
		$publishedAt = Carbon::createFromFormat('d/m/Y', $article['published_at']);

		$authorId = $this->getAuthorId($article['author']);

		$categoryId = $article['editorial_id'];
		if ($article['editorial_id'] == "9999")
		{
			$categoryId = ClippingCategory::firstOrCreate(['name' => $article['editorial_other']])->id;
		}

		$localityId = $article['locality_id'];
		if ($article['locality_id'] == "9999")
		{
			$localityId = ClippingLocality::firstOrCreate(['name' => $article['locality_other']]);
		}

		$vehicleId = $article['vehicle_id'];
		if ($article['vehicle_id'] == "9999")
		{
			$vehicleId = ClippingVehicle::firstOrCreate(['name' => $article['vehicle_other']])->id;
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

		$this->createImages($clipping, $article['image_main_urls'], true); // main
		$this->createImages($clipping, $article['image_snapshot_urls'], false, true); // snapshot
		$this->createImages($clipping, $article['image_other_urls']); // other images

		return $clipping;
	}

	private function createImages($clipping, $urls, $main = false, $snapshot = false)
	{
		$urls = explode("\r\n", $urls);

		$clippingFile = app()->make(ClippingFile::class);

		foreach ($urls as $url)
		{
			$clippingFile->createFor(
				$clipping,
				$main,
				$snapshot,
				$url,
				ClippingFileType::firstorCreate(['name' => 'image'])
			);
		}
	}

	/**
	 * @param $article
	 * @return static
	 */
	private function getAuthorId($author)
	{
		return $author ? ClippingAuthor::firstOrCreate(['name' => $author])->id : null;
	}
}
