<?php

namespace PragmaRX\Sdk\Services\Files\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use PragmaRX\Sdk\Services\Files\Commands\UploadFileCommand;
use Input;
use Redirect;
use Response;
use Request;
use File;
use Auth;

class Files extends BaseController {

	public function upload()
	{
		$input = [];

		$input['file'] = Input::file('file');

		$input['user'] = Auth::user();

		$file = $this->execute(UploadFileCommand::class, $input);

		$url = $file->getUrl($file);

		if (Request::ajax())
		{
			return Response::json(compact('url'));
		}

		return Redirect::back();
	}

}
