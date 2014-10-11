<?php

namespace PragmaRX\Sdk\Services\Connect\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class DisconnectionIsForbidden extends HttpResponseException {

	protected $message = 'paragraphs.connected-by-invitation-cannot-disconnect';

} 
