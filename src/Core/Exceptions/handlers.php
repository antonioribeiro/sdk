<?php

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\InvalidRequest $exception, $code)
{
	Flash::error(t('paragraphs.invalid-request'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\TokenExpired $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-expired'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\InvalidToken $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-invalid'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(Illuminate\Contracts\Validation\ValidationException $exception, $code)
{
	return new Illuminate\Http\JsonResponse($exception->errors()->all(), 422);

//	Flash::error(t('paragraphs.two-factor-token-invalid'));

//	return Redirect::home();
});

ExceptionHandler::addHandler(function(Symfony\Component\HttpKernel\Exception\HttpException $exception, $code)
{
	return Redirect::route('error', ['code' => $code]);
});
