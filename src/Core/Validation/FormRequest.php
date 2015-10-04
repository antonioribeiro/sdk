<?php

namespace PragmaRX\Sdk\Core\Validation;

use Input;
use Flash;
use Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

class FormRequest extends IlluminateFormRequest
{
	use AuthorizesRequests;

	public function rules()
	{
		return [];
	}

	public function forbiddenResponse()
	{
		if ($this->ajax())
		{
			return new JsonResponse([t('paragraphs.forbidden')], 403);
		}
		else
		{
			Flash::error(t('paragraphs.you-are-not-authorized'));

			return Redirect::back();
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
		if ($this->ajax())
		{
			return new JsonResponse($errors, 422);
		}
		else
		{
			Flash::errors($errors);

			return $this->redirector->to($this->getRedirectUrl())
						->withInput($this->except($this->dontFlash));
		}
	}

	public function validate()
	{
		$this->mergeRulesAndRouteParameters();

		if (method_exists($this, 'beforeValidate'))
		{
			$this->container->call([$this, 'beforeValidate']);
		}

		$result = parent::validate();

		if (method_exists($this, 'afterValidate'))
		{
			$this->container->call([$this, 'afterValidate']);
		}

		return $result;
	}

	private function mergeRulesAndRouteParameters()
	{
		if ( ! $this->route())
		{
			return $this->all();
		}

		foreach ($this->route()->parameters() as $key => $value)
		{
			$this->merge([$key => $value]);
		}

		$this->replace($this->all());
	}

	/**
	 * Deteremine if the request passes the authorization check.
	 *
	 * @return bool
	 */
	protected function passesAuthorization()
	{
		if (method_exists($this, 'authorize'))
		{
			return $this->container->call([$this, 'authorize']);
		}

		return true;
	}
}
