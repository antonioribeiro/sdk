<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class UserAlreadyActivated extends HttpResponseException {

	protected $message = 'paragraphs.account-already-activated';

}
