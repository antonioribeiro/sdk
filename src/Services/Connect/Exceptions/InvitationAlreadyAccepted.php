<?php

namespace PragmaRX\Sdk\Services\Connect\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvitationAlreadyAccepted extends HttpResponseException {

	protected $message = 'paragraphs.invitation-already-accepted';

}
