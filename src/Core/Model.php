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

    protected $casts = [
        'id' => 'string',
    ];

	use
		EventGenerator,
		PresentableTrait,
		IdentifiableTrait,
		ReloadableTrait;

	public static function boot()
	{
		parent::boot();
	}

	private function getUserId()
	{
		try {
			if (\Auth::check())
			{
				return \Auth::user()->getAuthIdentifier();
			}
		} catch (\Exception $e) {
			return null;
		}

		return null;
	}
}
