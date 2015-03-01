<?php

namespace PragmaRX\Sdk\Services\Statuses\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Statuses\Commands\PostStatusCommand;
use PragmaRX\Sdk\Services\Statuses\Data\Repositories\StatusRepository;
use PragmaRX\Sdk\Services\Statuses\Forms\PostStatus;

use Redirect;
use Flash;
use Input;
use Auth;
use View;

class Statuses extends BaseController {

	private $postStatusForm;

	/**
	 * @var StatusRepository
	 */
	private $statusRepository;

	/**
	 * @param PostStatus $postStatusForm
	 */
	public function __construct(PostStatus $postStatusForm, StatusRepository $statusRepository)
	{
		$this->postStatusForm = $postStatusForm;

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

	public function store()
	{
		$input = Input::all();

		$input['user_id'] = Auth::id();

		$this->postStatusForm->validate($input);

		$this->execute(PostStatusCommand::class, $input);

		Flash::message(t('paragraphs.status-posted'));

		return Redirect::back();
	}

}
