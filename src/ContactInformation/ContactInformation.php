<?php

namespace PragmaRX\SDK\ContactInformation;

use PragmaRX\SDK\Core\Model;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

class ContactInformation extends Model {

	use EventGenerator, PresentableTrait;

	protected $table = 'contact_information';

	protected $fillable = ['user_id', 'kind_id', 'info'];

	protected $presenter = 'PragmaRX\SDK\Users\ContactInformationPresenter';

	public function kind()
	{
		return $this->belongsTo('PragmaRX\SDK\Kinds\Kind');
	}

}
