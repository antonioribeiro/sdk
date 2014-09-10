<?php

namespace PragmaRX\Sdk\Core\Validation;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Input;
use Flash;

class FormRequest extends IlluminateFormRequest {

	public function forbiddenResponse()
	{
		if ($this->ajax())
		{
			return new JsonResponse([t('paragraphs.forbidden')], 403);
		}
		else
		{
			return new Response('Forbidden', 403);
		}
	}

	protected function getRedirectUrl()
	{
		if ($url = Input::get('referer-url'))
		{
			return $url;
		}

		return parent::getRedirectUrl();
	}

	public function response(array $errors)
	{
		Flash::errors($errors);

		return parent::response($errors);
	}

	public function validate(ValidationFactory $factory)
	{
		$this->mergeRulesAndRouteParameters();

		return parent::validate($factory);
	}

	private function mergeRulesAndRouteParameters()
	{
		foreach($this->route->parameters() as $key => $value)
		{
			Input::merge([$key => $value]);
		}

		$this->replace(Input::all());
	}

	/**
	 * Deteremine if the request fails the authorization check.
	 *
	 * @return bool
	 */
	protected function failsAuthorization()
	{
		if (method_exists($this, 'authorize'))
		{
			return ! $this->container->call([$this, 'authorize']);
		}

		return false;
	}

}
