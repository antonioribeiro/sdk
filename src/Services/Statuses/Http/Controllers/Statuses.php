<?php

namespace PragmaRX\Sdk\Services\Statuses\Http\Controllers;

use Auth;
use View;
use Flash;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Statuses\Http\Requests\PostStatus;
use PragmaRX\Sdk\Services\Statuses\Jobs\PostStatus as PostStatusJob;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;
use PragmaRX\Sdk\Services\Statuses\Http\Requests\PostStatus as PostStatusRequest;

class Statuses extends BaseController {

	/**
	 * @var StatusRepository
	 */
	private $statusRepository;

	/**
	 * @param PostStatus $postStatusForm
	 */
	public function __construct(StatusRepository $statusRepository)
	{
		$this->statusRepository = $statusRepository;
	}

	public function index()
	{
		if (Auth::user())
		{
			$statuses = $this->statusRepository->getFeedForUser(Auth::user());
		}
		else
		{
			$statuses = $this->statusRepository->getAll();
		}

		return View::make('statuses.index', compact('statuses'));
	}

	public function store(PostStatusRequest $postStatusRequest)
	{
		$input = $postStatusRequest->all();

		$input['user_id'] = Auth::id();

		dispatch(new PostStatusJob($input));

		Flash::message(t('paragraphs.status-posted'));

		return Redirect::back();
	}

}
