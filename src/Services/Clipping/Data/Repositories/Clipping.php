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
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingTag;
use PragmaRX\Sdk\Services\Clipping\Data\Entities\ClippingVehicle;
use PragmaRX\Sdk\Services\Tags\Data\Entities\Tag;

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

		$this->createFiles($clipping, $article['image_main_urls'], true); // main
		$this->createFiles($clipping, $article['image_snapshot_urls'], false, true); // snapshot
		$this->createFiles($clipping, $article['image_other_urls']); // other images
		$this->createFiles($clipping, $article['videos'], false, false, true); // other images

		$this->createTags($clipping, $article['tags']);

		return $clipping;
	}

	private function createFiles($clipping, $urls, $main = false, $snapshot = false, $video = false)
	{
		$urls = explode("\r\n", $urls);

		$clippingFile = app()->make(ClippingFile::class);

		foreach ($urls as $url)
		{
			$clippingFile->createFor(
				$clipping,
				$main,
				$snapshot,
				$video,
				$url,
				ClippingFileType::firstorCreate(['name' => 'image'])
			);
		}
	}

	/**
	 * @param $author
	 * @return static
	 */
	private function getAuthorId($author)
	{
		return $author ? ClippingAuthor::firstOrCreate(['name' => $author])->id : null;
	}

	private function createTags($clipping, $tags)
	{
		foreach ($tags as $tag)
		{
			if ($tag = Tag::findOrCreateTag($tag))
			{
				ClippingTag::firstOrCreate(
					[
						'clipping_id' => $clipping->id,
						'tag_id' => $tag->id
					]
				);
			}
		}
	}
}
