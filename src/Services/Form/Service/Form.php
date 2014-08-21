<?php

namespace PragmaRX\SDK\Services\Form\Service;

use App;

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

		if (is_object($params1))
		{
			$method = 'model';
		}
		else
		{
			$method = 'open';
		}

		return
			$this->form->{$method}($params1, $params2) .
			$this->makeReferer();
	}

	private function makeReferer()
	{
		return $this->form->input('hidden', 'referer-url', '', ['id' => 'referer-url']);
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(
			array($this->form, $name),
			$arguments
		);
	}
}
