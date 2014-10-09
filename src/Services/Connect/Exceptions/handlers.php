<?php

App::make('exception')->error(function(PragmaRX\Sdk\Services\Connect\Exceptions\InvalidInvitationCode $exception, $code)
{
	Flash::error(t('paragraphs.invalid-invitation-code'));

	return Redirect::home();
});

App::make('exception')->error(function(PragmaRX\Sdk\Services\Connect\Exceptions\InvitationAlreadyAccepted $exception, $code)
{
	Flash::error(t('paragraphs.invitation-already-accepted'));

	return Redirect::home();
});

App::make('exception')->error(function(PragmaRX\Sdk\Services\Connect\Exceptions\DisconnectionIsForbidden $exception, $code)
{
	Flash::error(t('paragraphs.connected-by-invitation-cannot-disconnect'));

	return Redirect::back();
});
