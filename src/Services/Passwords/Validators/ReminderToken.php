<?php

namespace PragmaRX\Sdk\Services\Passwords\Validators;

use PragmaRX\Sdk\Core\Traits\TranslatableValidationMessageTrait;

class ReminderToken {

	use TranslatableValidationMessageTrait;

	protected $rules = [
	    'password_token' => 'exists:password_reminders,token'
	];

	protected $messages = [
		'password_token.exists' => 'pragmarx/sdk::paragraphs.invalid_password_token'
	];

} 
