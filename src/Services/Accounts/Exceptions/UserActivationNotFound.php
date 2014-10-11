<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class UserActivationNotFound extends HttpResponseException {

	protected $message = 'paragraphs.user-activation-not-found';

}
