<?php

namespace PragmaRX\Sdk\Services\Connect\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidInvitationCode extends HttpResponseException {

	protected $message = 'paragraphs.invalid-invitation-code';

}
