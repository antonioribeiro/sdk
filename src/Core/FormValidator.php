<?php

namespace PragmaRX\SDK\Core;

use Laracasts\Validation\FormValidator as LaracastsFormValidator;

abstract class FormValidator extends LaracastsFormValidator {

	public function validate($formData, $overrides = [])
	{
		$this->rules = array_merge($this->rules, $overrides);

		return parent::validate($formData);
	}

}
