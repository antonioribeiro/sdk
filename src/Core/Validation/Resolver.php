<?php

namespace PragmaRX\Sdk\Core\Validation;

use Illuminate\Validation\Validator;
use ZIPcode;

class Resolver extends Validator {

	public function validatePhone($attribute, $value, $parameters)
	{
		return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
	}

	public function validateZip($attribute, $value, $parameters)
	{
		$result = ZIPCode::find($value);

		return $result->success;
	}

}
