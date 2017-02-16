<?php

namespace PragmaRX\Sdk\Services\Redirect\Service;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;

class Redirect extends Redirector {

	/**
	 * @param $name
	 * @param array $parameters
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public function __call($name, array $parameters = [])
	{
		if ($this->wantsJson())
		{
			if ($name == 'route')
			{
				$response = [
					'redirect' => route_ajax(
						$parameters[0],
						isset($parameters[1]) ? $parameters[1] : null
					)
			    ];
			}
			elseif ($name == 'back')
			{
				$response = [
					'redirect' => $this->__getReferer()
			    ];
			}
			else
			{
				$response = [
					'result' => $parameters,
					'success' => true,
				];
			}

			return new JsonResponse($response);
		}

		if ($name == 'back')
		{
			return $this->back($parameters);
		}

		return $this->call($name, $parameters);
	}

	public function route_no_ajax($route, $parameters = array(), $status = 302, $headers = array())
	{
		return $this->route($route, $parameters = array(), $status = 302, $headers = array(), false);
	}

	public function route($route, $parameters = array(), $status = 302, $headers = array(), $ajax = true)
	{
		if ($this->wantsJson())
		{
			return new JsonResponse(['redirect' => route_ajax($route, $parameters)]);
		}

		if ($this->wantsAjax($ajax) && $this->isBasedOnAjax())
		{
			return parent::to(route_ajax($route, $parameters));
		}

		return parent::to(route($route, $parameters));
	}

	public function back($status = 302, $headers = array(), $fallback = false)
	{
		$back = $this->__getReferer();

		if ($this->wantsJson())
		{
			return new JsonResponse(['redirect' => $back]);
		}

		return $this->createRedirect($back, $status, $headers);
	}

	/**
	 * @return array|mixed|string
	 */
	public function __getReferer()
	{
		if ( ! $referer = $this->getRefererFromRequest())
		{
			$referer = $this->generator->getRequest()->instance()->headers->get('referer');
		}

		if ($this->__isBadReferer($referer))
		{
			$referer = $this->generator->getRequest()->getUri();
		}

		if ( ! $referer || $this->__isBadReferer($referer))
		{
			$referer = route('home');
		}

		if ($this->wantsJson() || $this->wantsAjax())
		{
			if ($this->isBasedOnAjax())
			{
				$referer = convert_url_to_ajax($referer);
			}
		}

		return $referer;
	}

	/**
	 * @param $referer
	 * @return bool
	 */
	protected function __isBadReferer($referer)
	{
		return $this->generator->getRequest()->method() != 'GET' && $referer == $this->__getOrigin();
	}

	/**
	 * @return string
	 */
	protected function __getOrigin()
	{
		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

		return "$origin/";
	}

	private function wantsJson()
	{
		return $this->generator->getRequest()->ajax();
	}

	private function wantsAjax($default = true)
	{
		return
				! $this->generator->getRequest()->get('no-return-ajax-url')
				? $default
				: false;
	}

	private function getRefererFromRequest()
	{
		if ( ! $referrer = $this->generator->getRequest()->get('referer-url'))
		{
			if ($referrer = $this->generator->getRequest()->get('referer-href-url'))
			{
				if ($this->isBasedOnAjax())
				{
					$referrer = route('home') . '/#' . $referrer;
				}
			}
		}

		return $referrer;
	}

	public function isBasedOnAjax()
	{
		return \Config::get('sdk.ajax_based_url');
	}

}
