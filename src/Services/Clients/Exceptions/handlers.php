<?php

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Services\Clients\Exceptions\InvalidInvitationCode $exception, $code)
{
	Flash::error(t('paragraphs.invalid-invitation-code'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Services\Clients\Exceptions\InvitationAlreadyAccepted $exception, $code)
{
	Flash::error(t('paragraphs.invitation-already-accepted'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Services\Clients\Exceptions\DisconnectionIsForbidden $exception, $code)
{
	Flash::error(t('paragraphs.connected-by-invitation-cannot-disconnect'));

	return Redirect::back();
});
