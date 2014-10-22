<?php

namespace PragmaRX\Sdk\Services\Groups\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use PragmaRX\Sdk\Services\Groups\Commands\AddGroupCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;
use PragmaRX\Sdk\Services\Groups\Http\Requests\AddGroup as AddGroupRequest;
use Redirect;
use Response;
use View;
use Auth;
use Flash;

class Groups extends BaseController {

	/**
	 * @var GroupRepository
	 */
	private $groupRepository;

	public function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

	public function index()
	{
		$groups = $this->groupRepository->getAllFrom(Auth::user());

		$connectionsAndGroups = $this->groupRepository->getConnectionsAndGroups(Auth::user());

		return View::make('groups.index')
				->with('groups', $groups)
				->with('connections_and_groups', $connectionsAndGroups)
				->with('owner', Auth::user());
	}

	public function validate(AddGroupRequest $request)
	{
		return Response::json(['success' => true]);
	}

	public function store(AddGroupRequest $request)
	{
		$input = ['user' => Auth::user()] + $request->all();

		$this->execute(AddGroupCommand::class, $input);

		Flash::message(t('paragraphs.group-added'));

		return Redirect::back();
	}

}
