<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidActivationToken extends HttpResponseException
{
    protected $message = 'paragraphs.invalid-activation-token';
}
