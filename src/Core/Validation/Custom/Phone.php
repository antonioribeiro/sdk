<?php

namespace PragmaRX\Sdk\Core\Validation\Custom;

use Illuminate\Validation\Validator;

class Phone extends Validator {

	public function validatePhone($attribute, $value, $parameters)
	{
		return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
	}

}
