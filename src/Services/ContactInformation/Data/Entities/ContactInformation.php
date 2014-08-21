<?php

namespace PragmaRX\SDK\Services\ContactInformation\Data\Entities;

use PragmaRX\SDK\Core\Model;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

class ContactInformation extends Model {

	use EventGenerator, PresentableTrait;

	protected $table = 'contact_information';

	protected $fillable = ['user_id', 'kind_id', 'info'];

	protected $presenter = 'PragmaRX\SDK\Services\Users\ContactInformationPresenter';

	public function kind()
	{
		return $this->belongsTo('PragmaRX\SDK\Services\Kinds\Data\Entities\Kind');
	}

}
