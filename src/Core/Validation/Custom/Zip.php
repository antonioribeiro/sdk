<?php

namespace PragmaRX\Sdk\Core\Validation\Custom;

use Illuminate\Validation\Validator;

class Zip extends Validator {

	public function validateZip($attribute, $value, $parameters)
	{
		return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
	}

}