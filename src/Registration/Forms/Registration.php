<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 15/07/2014
 * Time: 12:31
 */

namespace PragmaRX\SDK\Registration\Forms;

use Laracasts\Validation\FormValidator;

class Registration extends FormValidator {

	protected $rules = [
		'first_name' => 'required',
		'username' => 'required|unique:users',
	    'email' => 'required|email|unique:users',
	    'password' => 'required|confirmed',
	];
} 
