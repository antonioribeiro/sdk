<?php

namespace PragmaRX\Sdk\Services\Settings\Http\Controllers;

use Auth;
use View;
use Flash;
use Redirect;
use PragmaRX\Sdk\Services\Settings\Jobs\UpdateJob;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Settings\Http\Requests\Update as UpdateRequest;

class Settings extends BaseController {

	public function edit()
	{
		$user = Auth::user();

		return View::make('settings.edit')->with('user', $user);
	}

	public function update(UpdateRequest $request)
	{
		$input = [
			'user' => Auth::user(),
			'input' => $request->except('_method', '_token', 'referer-url'),
		];

		dispatch(new UpdateJob($input));

		Flash::message(t('paragraphs.your-settings-were-updated'));

		return Redirect::back();
	}
}
