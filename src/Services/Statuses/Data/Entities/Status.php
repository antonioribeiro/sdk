<?php

namespace PragmaRX\Sdk\Services\Statuses\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Statuses\Events\StatusWasPublished;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

class Status extends Model {

	use EventGenerator, PresentableTrait;

	protected $fillable = ['body'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statuses';

	protected $presenter = 'PragmaRX\Sdk\Services\Statuses\Data\Entities\StatusPresenter';

	/**
	 * Publish a new status
	 *
	 * @param $body
	 * @return static
	 */
	public static function publish($body)
	{
		$status = new static(compact('body'));

		$status->raise(new StatusWasPublished($status));

		return $status;
	}

	public function user()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Users\Data\Entities\User');
	}
}
