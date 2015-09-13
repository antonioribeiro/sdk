<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Product';

	protected $fillable = [

	];

	public function author()
	{
		return $this->belongsTo(ProductsAuthor::class, 'author_id');
	}

}
