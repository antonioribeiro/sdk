<?php

namespace PragmaRX\Sdk\Services\Connect\Http\Requests;

use PragmaRX\Sdk\Core\Validation\FormRequest;
use Validator;

class Invite extends FormRequest {

	private $rules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return $this->rules;
	}

	public function beforeValidate()
	{
		$this->rules = [];

		$input = [];

		$input['emails'] = [];

		$emails = $this->extractEmails($this->all()['emails']);

		foreach ($emails as $email)
		{
			$this->rules['email: '.$email] = 'email|unique:users,email';

			$input['email: '.$email] = $email;

			$input['emails'][] = $email;
		}

		$this->replace($input);

		Validator::replacer('unique', function($message, $attribute, $rule, $parameters)
		{
			return $attribute.' '.t('paragraphs.already-a-user');
		});
	}

	private function extractEmails($emails)
	{
		return preg_split('/[,;\s]+/', $emails, -1, PREG_SPLIT_NO_EMPTY);
	}

}