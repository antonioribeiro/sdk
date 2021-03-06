<?php

namespace PragmaRX\Sdk\Services\Groups\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use PragmaRX\Sdk\Services\Groups\Jobs\AddGroup as AddGroupJob;
use PragmaRX\Sdk\Services\Groups\Jobs\AddMembersToGroup as AddMembersToGroupJob;
use PragmaRX\Sdk\Services\Groups\Jobs\DeleteGroup as DeleteGroupJob;
use PragmaRX\Sdk\Services\Groups\Jobs\DeleteGroupMembers as DeleteGroupMembersJob;
use PragmaRX\Sdk\Services\Groups\Jobs\UpdateGroup as UpdateGroupJob;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;
use PragmaRX\Sdk\Services\Groups\Http\Requests\AddGroup as AddGroupRequest;
use PragmaRX\Sdk\Services\Groups\Http\Requests\AddMembers as AddMembersRequest;
use PragmaRX\Sdk\Services\Groups\Http\Requests\DeleteGroup as DeleteGroupRequest;
use PragmaRX\Sdk\Services\Groups\Http\Requests\DeleteMembers as DeleteMembersRequest;
use PragmaRX\Sdk\Services\Groups\Http\Requests\UpdateGroup as UpdateGroupRequest;
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
		$groups = $this->groupRepository->getGroupsFrom(Auth::user());

		$connectionsAndGroups = $this->groupRepository->getConnectionsAndGroups(Auth::user());

		return View::make('groups.index')
				->with('groups', $groups)
				->with('connections_and_groups', $connectionsAndGroups)
				->with('owner', Auth::user());
	}

	public function validateData(AddGroupRequest $request)
	{
		return $this->success();
	}

	public function store(AddGroupRequest $request)
	{
		$input = ['user' => Auth::user()] + $request->all();

		dispatch(new AddGroupJob($input));

		Flash::message(t('paragraphs.group-added'));

		return Redirect::back();
	}

	public function delete(DeleteGroupRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'group_id' => $id,
		];

		dispatch(new DeleteGroupJob($input));

		Flash::message(t('paragraphs.group-deleted'));

		return Redirect::back();
	}

	public function addMembers(AddMembersRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'group_id' => $id,
		    'members' => $request->get('members'),
		];

		$members = dispatch(new AddMembersToGroupJob($input));

		Flash::message(t(count($members) > 1 ? 'paragraphs.members-added' : 'paragraphs.member-added'));

		return Redirect::back();
	}

	public function addMembersValidate(AddMembersRequest $request)
	{
		return $this->success();
	}

	public function update(UpdateGroupRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'name' => $request->get('name'),
			'group_id' => $request->get('id'),
			'members' => $request->get('members', []),
			'administrators' => $request->get('administrators', []),
		];

		dispatch(new UpdateGroupJob($input));

		Flash::message(t('paragraphs.group-was-updated'));

		return Redirect::back();
	}

	public function deleteMembers(DeleteMembersRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'group_id' => $request->get('id'),
			'members' => $request->get('members', []),
			'administrators' => $request->get('administrators', []),
		];

		dispatch(new DeleteGroupMembersJob($input));

		Flash::message(t('paragraphs.one-or-more-members-deleted'));

		return Redirect::back();
	}

}
