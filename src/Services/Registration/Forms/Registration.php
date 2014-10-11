<?php

namespace PragmaRX\Sdk\Services\Registration\Forms;

use Laracasts\Validation\FormValidator;

class Registration extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'username' => 'required|unique:users',
	    'email' => 'required|email|unique:users',
	    'password' => 'required|confirmed',
	];
} 
