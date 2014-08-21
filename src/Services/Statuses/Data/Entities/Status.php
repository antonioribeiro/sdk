<?php

namespace PragmaRX\SDK\Services\Statuses\Data\Entities;

use PragmaRX\SDK\Core\Model;
use PragmaRX\SDK\Services\Statuses\Events\StatusWasPublished;
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

	protected $presenter = 'PragmaRX\SDK\Services\Statuses\Data\Entities\StatusPresenter';

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
		return $this->belongsTo('PragmaRX\SDK\Services\Users\Data\Entities\User');
	}
}
