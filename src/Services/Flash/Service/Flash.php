<?php

namespace PragmaRX\Sdk\Services\Flash\Service;

use Illuminate\Support\MessageBag;
use Session;

class Flash {

	private $arrayName = 'sdk.flash.messages';

	public function __call($name, $arguments)
	{
		$message = $arguments[0];

		$title = isset($arguments[1]) ? $arguments[1] : null;

		$this->addMessage($name, $message, $title);
	}

	private function addMessage($kind, $message, $title = null)
	{
		$result = Session::get($this->arrayName) ?: [];

		if ($message instanceof MessageBag)
		{
			$messages = $message->all();
		}
		else
		{
			$messages = [$message];
		}

		foreach ($messages as $message)
		{
			if ( ! is_array($message))
			{
				$message = [$message];
			}

			foreach ($message as $item)
			{
				$result[$kind.$item] = [
					'kind' => $this->getKind($kind),
					'icon' => $this->getIcon($kind),
					'message' => $item,
					'title' => $title,
				];
			}
		}

		Session::put($this->arrayName, $result);
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

	public function errors($errors)
	{
		if ( ! is_array($errors))
		{
			$errors = [$errors];
		}

		if ($errors instanceof \Illuminate\Support\MessageBag)
		{
			$errors = $errors->all();
		}

		foreach ($errors as $error)
		{
			$this->error($error);
		}
	}
}
