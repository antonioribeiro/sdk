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
		Input::merge(['user' => Auth::user()]);

		$file = $this->execute(
			UploadFileCommand::class,
			Input::all()
		);

		if (Request::ajax())
		{
			$url = $file->getUrl($file);
			$id = $file->id;

			return Response::json(compact('url', 'id'));
		}

		return Redirect::back();
	}

}
