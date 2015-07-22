<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Clipping extends Presenter
{
	public function imageUrl($x = 304, $y = 192)
	{
		$image = $this->entity->mainFile();

		if ( ! $image || ! $image->file)
		{
			return "http://lorempixel.com/$x/$y/?" . $this->id;
		}

		return $image->file->file->getUrl();
	}

	public function snapshotUrl()
	{
		$image = $this->entity->snapshotFile();

		if ( ! $image || ! $image->file)
		{
			return null;
		}

		return $image->file->file->getUrl();
	}
}
