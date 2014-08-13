<?php

namespace PragmaRX\SDK\Kinds;

use PragmaRX\SDK\Core\Model;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

class Kind extends Model {

	use EventGenerator, PresentableTrait;

	protected $fillable = ['name', 'icon'];

	protected $presenter = 'PragmaRX\SDK\Users\ContactInformationPresenter';

}
