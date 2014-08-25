<?php

namespace PragmaRX\Sdk\Services\Profiles\Forms;

use PragmaRX\Sdk\Core\FormValidator;

class Edit extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'last_name' => 'required',
	    'email' => 'required|email',
	];

} 
