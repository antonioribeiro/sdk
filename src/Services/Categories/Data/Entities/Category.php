<?php

/**
 * Uses
 *		https://github.com/etrepat/baum
 */

namespace PragmaRX\Sdk\Services\Categories\Data\Entities;

use Baum\Node;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;

class Category extends Node
{
	use IdentifiableTrait;

	protected $table = 'categories';

	protected $parentColumn = 'parent_id';

	protected $leftColumn = 'left';

	protected $rightColumn = 'right';

	protected $depthColumn = 'depth';

	protected $guarded = [
		'id',
		'parent_id',
		'left',
		'right',
		'depth',
	];
}
