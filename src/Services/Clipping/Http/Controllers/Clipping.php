<?php

namespace PragmaRX\Sdk\Services\Clipping\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Clipping\Data\Repositories\Clipping as ClippingRepository;

class Clipping extends BaseController
{
	/**
	 * @var ClippingRepository
	 */
	private $clippingRepository;

	public function __construct(ClippingRepository $clippingRepository)
	{
		$this->clippingRepository = $clippingRepository;
	}

	public function index()
	{
		return
			view('clipping.posts')
				->with('posts', $this->clippingRepository->paginated());
	}

	public function post($id)
	{
		$post = $this->clippingRepository->findPostById($id);

		return view('clipping.post')->with('post', $post);
	}
}
