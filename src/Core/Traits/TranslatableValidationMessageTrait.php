<?php

namespace PragmaRX\SDK\Core\Traits;


use Lang;

trait TranslatableValidationMessageTrait {

	/**
	 * Validate the form data
	 *
	 * @param  mixed $formData
	 * @return mixed
	 * @throws FormValidationException
	 */
	public function validate($formData)
	{
		$this->translateMessages();

		return parent::validate($formData);
	}

	/**
	 * Translate all validation messages.
	 *
	 * @return void
	 */
	public function translateMessages()
	{
		foreach($this->messages as $key => $message)
		{
			$this->messages[$key] = Lang::trans($message);
		}
	}
} 
