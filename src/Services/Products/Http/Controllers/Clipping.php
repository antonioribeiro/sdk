<?php

namespace PragmaRX\Sdk\Services\Products\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Products\Data\Repositories\Products as ProductsRepository;

class Products extends BaseController
{
	/**
	 * @var ProductsRepository
	 */
	private $clippingRepository;

	public function __construct(ProductsRepository $clippingRepository)
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
