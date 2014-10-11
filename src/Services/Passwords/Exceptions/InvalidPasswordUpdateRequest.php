<?php

namespace PragmaRX\Sdk\Services\Passwords\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidPasswordUpdateRequest extends HttpResponseException {

	protected $message = 'paragraphs.invalid-password-update-request';

}
