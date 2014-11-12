<?php

namespace PragmaRX\Sdk\Services\Form\Service;

use App;
use Input;

class Form {

	public function __construct()
	{
	    $this->form = App::make('form');
	}

	public function opener($params1, $params2 = null)
	{
		if(is_array($params1) && isset($params1['model']))
		{
			$params2 = $params1;

			unset($params2['model']);

			$params1 = $params1['model'];
		}

		$returnAjaxUrl = true;

		if(is_array($params2) && isset($params2['no-return-ajax-url']))
		{
			$params = &$params2;

			unset($params2['no-return-ajax-url']);
		}
		elseif(is_array($params1) && isset($params1['no-return-ajax-url']))
		{
			$params = &$params1;

			unset($params1['no-return-ajax-url']);
		}
		else
		{
			$params = [];

			$returnAjaxUrl = false;
		}

		if (is_object($params1))
		{
			$method = 'model';
		}
		else
		{
			$method = 'open';
		}

		$form =
			$this->form->{$method}($params1, $params2) .
			$this->makeReferer() .
			$this->addToken();

		if ($returnAjaxUrl)
		{
			$form .= Form::hidden('no-return-ajax-url', 'true');
		}

		return $form;
	}

	private function makeReferer()
	{
		return $this->form->input('hidden', 'referer-url', '', ['class' => 'referer-url']);
	}

	private function addToken()
	{
		$token = isset($token) ? $token : null;
		$token = isset($token) ? $token : Input::get('token');
		$token = isset($token) ? $token : Input::query('token');

		if (isset($token))
		{
			return Form::hidden('token', $token);
		}
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(
			array($this->form, $name),
			$arguments
		);
	}

}
