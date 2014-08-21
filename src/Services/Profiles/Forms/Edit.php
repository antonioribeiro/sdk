<?php

namespace PragmaRX\SDK\Services\Profiles\Forms;

use PragmaRX\SDK\Core\FormValidator;

class Edit extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'last_name' => 'required',
	    'email' => 'required|email',
	];

} 
