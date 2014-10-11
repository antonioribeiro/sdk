<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class UserNotActivated extends HttpResponseException {

	protected $message = 'paragraphs.account-not-yet-activated';

}
