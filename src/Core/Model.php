<?php

namespace PragmaRX\Sdk\Core;

use PragmaRX\Sdk\Core\Traits\ReloadableTrait;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;
use PragmaRX\Sdk\Services\Bus\Events\EventGenerator;
use PragmaRX\Sdk\Services\Presenter\PresentableTrait;

class Model extends Eloquent
{
	use RevisionableTrait;

	protected $revisionCreationsEnabled = true;

	protected $dates = ['created_at', 'updated_at'];

	use
		EventGenerator,
		PresentableTrait,
		IdentifiableTrait,
		ReloadableTrait;

}
