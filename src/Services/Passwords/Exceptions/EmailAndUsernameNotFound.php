<?php

namespace PragmaRX\Sdk\Services\Passwords\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class EmailAndUsernameNotFound extends HttpResponseException {

	protected $message = 'paragraphs.user-not-found';

}
