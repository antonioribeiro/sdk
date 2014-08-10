<?php

App::error(function(Cartalyst\Sentinel\Checkpoints\NotActivatedException $exception, $code)
{
	return Redirect::back()->withInput()->withErrors(t('paragraphs.account-not-yet-activated'));
});
