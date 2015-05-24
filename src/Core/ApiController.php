<?php

namespace PragmaRX\Sdk\Core;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class ApiController extends Controller
{

	/**
	 *
	 * @var null
	 */
	private $statusCode = SymfonyResponse::HTTP_OK;

	/**
	 * Send a success response.
	 *
	 * @param null $data
	 * @param int $httpCode
	 * @return mixed
	 */
	public function respondWithSuccess($data = null, $httpCode = SymfonyResponse::HTTP_OK)
	{
		return $this->setStatusCode(SymfonyResponse::HTTP_OK)
			->sendResponse(true, null, $data, $httpCode);
	}

	/**
	 * Send an error response.
	 *
	 * Let's use Twitter error messages?
	 *    https://dev.twitter.com/overview/api/response-codes
	 *
	 * @param null $data
	 * @param int $httpCode
	 * @return mixed
	 */
	public function respondWithError($message, $data = null, $httpCode = SymfonyResponse::HTTP_NOT_FOUND)
	{
		return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)
			->sendResponse(false, $message, $data, $httpCode);
	}

	/**
	 * 404 response.
	 *
	 * @param string $message
	 * @param null $data
	 * @return mixed
	 */
	public function respondNotFound($message = 'Not found!', $data = null)
	{
		return $this->respondWithError($message, $data, SymfonyResponse::HTTP_NOT_FOUND);
	}

	/**
	 * Send a response.
	 *
	 * @param $success
	 * @param $message
	 * @param $data
	 * @param $httpCode
	 * @return mixed
	 */
	private function sendResponse($success, $message, $data, $httpCode)
	{
		return Response::json(
			[
				'success' => $success,
				'code' => $this->getStatusCode(),
				'message' => $message,
				'data' => $data,
			],
			$httpCode
		);
	}

	/**
	 * Status code getter.
	 *
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Status code setter.
	 *
	 * @param int $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

}
