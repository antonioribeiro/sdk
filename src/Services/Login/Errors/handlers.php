<?php

App::make('exception')->error(function(Cartalyst\Sentinel\Checkpoints\NotActivatedException $exception, $code)
{
	Flash::error(t('paragraphs.account-not-yet-activated'));

	return Redirect::back()->withInput();
});
