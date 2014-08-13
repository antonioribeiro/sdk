<?php

namespace PragmaRX\SDK\Flash;

use Session;

class Service {

	private $arrayName = 'sdk.flash.messages';

	public function __call($name, $arguments)
	{
		$message = $arguments[0];

		$title = isset($arguments[1]) ? $arguments[1] : null;

		$this->addMessage($name, $message, $title);
	}

	private function addMessage($kind, $message, $title = null)
	{
		$messages = Session::get($this->arrayName) ?: [];

		$messages[$kind.$message] = [
			'kind' => $this->getKind($kind),
			'icon' => $this->getIcon($kind),
		    'message' => $message,
		    'title' => $title,
		];

		Session::put($this->arrayName, $messages);
	}

	public function popMessages()
	{
		$messages = Session::get($this->arrayName) ?: [];

		Session::forget($this->arrayName);

		return $messages;
	}

	private function getKind($kind)
	{
		$kind = $kind == 'message' ? 'info' : $kind;

		$kind = $kind == 'error' ? 'danger' : $kind;

		return $kind;
	}

	private function getIcon($icon)
	{
		$icon = $icon == 'warning' ? 'fa-warning' : $icon;

		$icon = $icon == 'success' ? 'fa-check' : $icon;

		$icon = $icon == 'info' || $icon == 'message'  ? 'fa-info' : $icon;

		$icon = $icon == 'danger' || $icon == 'error'  ? 'fa-times' : $icon;

		return $icon;
	}
}
