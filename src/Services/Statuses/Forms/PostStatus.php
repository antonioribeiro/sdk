<?php


namespace PragmaRX\Sdk\Services\Statuses\Forms;

use Laracasts\Validation\FormValidator;

class PostStatus extends FormValidator {

	protected $rules = [
	    'body' => 'required',
	];

} 
