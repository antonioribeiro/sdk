<?php

namespace PragmaRX\Sdk\Services\Settings\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use PragmaRX\Sdk\Services\Settings\Commands\UpdateCommand;
use PragmaRX\Sdk\Services\Settings\Http\Requests\Update as UpdateRequest;
use Redirect;
use View;

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

		$this->execute(UpdateCommand::class, $input);

		Flash::message(t('paragraphs.your-settings-were-updated'));

		return Redirect::back();
	}

}
