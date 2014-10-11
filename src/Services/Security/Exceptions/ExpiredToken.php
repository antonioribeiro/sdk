<?php

namespace PragmaRX\Sdk\Services\Security\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class ExpiredToken extends HttpResponseException {

	protected $message = 'paragraphs.token-expired';

}
