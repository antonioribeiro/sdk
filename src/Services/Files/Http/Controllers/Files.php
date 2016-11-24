<?php

namespace PragmaRX\Sdk\Services\Files\Http\Controllers;


use Auth;
use Input;
use Redirect;
use Response;
use Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Files\Jobs\UploadFile as UploadFileJob;

class Files extends BaseController
{
	public function upload()
	{
		Input::merge(['user' => Auth::user()]);

		$file = dispatch(new UploadFileJob(Input::all()));

		if (Request::ajax())
		{
			$url = $file->getUrl($file);
			$id = $file->id;

			return Response::json(compact('url', 'id'));
		}

		return Redirect::back();
	}
}
