<?php

namespace PragmaRX\SDK\Services\Login\Forms;

use Laracasts\Validation\FormValidator;

class SignIn extends FormValidator {

	protected $rules = [
	    'email' => 'required|email|exists:users,email',
	    'password' => 'required',
	];

} 
