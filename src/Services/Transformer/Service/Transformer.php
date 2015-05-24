<?php

namespace PragmaRX\Sdk\Services\Transformer\Service;

use Illuminate\Database\Eloquent\Collection;

abstract class Transformer {

	/**
	 * Transform a collection.
	 *
	 * @param Collection $collection
	 * @return array
	 */
	public function transformCollection(Collection $collection)
	{
		return array_map([$this, 'transform'], $collection->toArray());
	}

	/**
	 *  Transform Data.
	 *
	 * @param $data
	 * @return mixed
	 */
	abstract public function transform($data);

}
