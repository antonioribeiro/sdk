<?php

namespace PragmaRX\Sdk\Core;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException as IlluminateHttpResponseException;

use Redirect;
use Flash;

class HttpResponseException extends IlluminateHttpResponseException {

	protected $message = null;

	/**
	 * Create a new HTTP response exception instance.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Response  $response
	 * @return void
	 */
	public function __construct($response = null)
	{
		$this->response = $this->makeResponse($response);
	}

	private function makeResponse($response)
	{
		if ( ! $response instanceof Response)
		{
			if ( ! is_array($response))
			{
				$response = $response ? [$response] : $this->getDefaultMessages();
			}

			Flash::errors($response);

			$response = Redirect::back();

			if ( ! $response instanceof \Illuminate\Http\JsonResponse)
			{
				$response->withInput();
			}
		}

		return $response;
	}

	private function getDefaultMessages()
	{
		if (is_array($this->message))
		{
			$messages = $this->message;
		}
		else
		{
			$messages = $this->message ? [$this->message] : [];
		}

		//
		// Try to translate the message
		//
		foreach($messages as $key => $message)
		{
			$messages[$key] = t($message);
		}

		return $messages;
	}

}
