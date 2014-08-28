<?php

namespace PragmaRX\Sdk\Services\Users\Data\Repositories;

use PragmaRX\Sdk\Services\ContactInformation\Data\Entities\ContactInformation;
use PragmaRX\Sdk\Services\EmailChanges\Data\Entities\EmailChange;
use PragmaRX\Sdk\Services\EmailChanges\Events\EmailChangeMessageSent;
use PragmaRX\Sdk\Services\EmailChanges\Events\EmailChangeRequested;
use PragmaRX\Sdk\Services\Mailer\Service\Mailer;
use PragmaRX\Sdk\Services\Profiles\Events\ProfileVisited;
use PragmaRX\Sdk\Services\ProfilesVisits\Data\Entities\ProfileVisit;

use Activation;
use Flash;
use Auth;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use Rhumsaa\Uuid\Uuid;

class UserRepository {

	/**
	 * Save a user.
	 *
	 * @param User $user
	 * @return bool
	 */
	public function save($user)
	{
		return $user->save();
	}

	/**
	 * Get a paginated list of all users.
	 *
	 * @param int $howMany
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getPaginated($howMany = 25)
	{
		return User::orderBy('first_name')->simplePaginate($howMany);
	}

	/**
	 * Fetch a user by their username.
	 *
	 * @param $username
	 * @return \Illuminate\Database\Eloquent\Model|null|static
	 */
	public function findByUsername($username)
	{
		return User::where('username', $username)->first();

//		return User::with(['statuses' => function($query)
//		{
//			$query->latest();
//		}])->where('username', $username)->first();
	}

	/**
	 * Find a user by id.
	 *
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
	 */
	public function findById($id)
	{
		return User::findOrFail($id);
	}

	public function findByEmail($email)
	{
		return User::where('email', $email)->first();
	}

	public function activate($email, $token)
	{
		return User::activate($email, $token);
	}

	public function sendUserActivationEmail($user)
	{
		Mailer::send(
			'emails.register.user-registered',
			$user,
			t('captions.activate-your-account')
		);

		Flash::message(t('paragraphs.activation-email-sent'));
	}

	public function checkAndCreateActivation($user)
	{
		if ( ! Activation::exists($user))
		{
			Activation::create($user);

			$this->sendUserActivationEmail($user);
		}
	}

	public function checkActivationByEmail($email)
	{
		$this->checkAndCreateActivation(
			$this->findByEmail($email)
		);
	}

	/**
	 * Follow a user.
	 *
	 * @param $user_to_follow
	 * @param $user_id
	 * @return mixed
	 */
	public function follow($user_to_follow, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_follow = $this->findByUsername($user_to_follow);

		if ( ! $user_to_follow->isFollowedBy($user))
		{
			$user = $user->following()->attach($user_to_follow->id);
		}

		return $user;
	}

	/**
	 * Unfollow a user.
	 *
	 * @param $user_to_unfollow
	 * @param $user_id
	 * @return mixed
	 */
	public function unfollow($user_to_unfollow, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_unfollow = $this->findByUsername($user_to_unfollow);

		return $user->following()->detach($user_to_unfollow->id);
	}

	/**
	 * Connect to a user.
	 *
	 * @param $user_to_connect
	 * @param $user_id
	 * @return mixed
	 */
	public function connect($user_to_connect, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_connect = $this->findByUsername($user_to_connect);

		if ( ! $user->isConnectedOrIsPendingTo($user_to_connect))
		{
			$user = $user->connections()->attach($user_to_connect->id);
		}

		return $user;
	}

	/**
	 * Disconnect from a user
	 *
	 * @param $user_to_disconnect
	 * @param $user_id
	 * @return mixed
	 */
	public function disconnect($user_to_disconnect, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_disconnect = $this->findByUsername($user_to_disconnect);

		return $user->connections()->detach($user_to_disconnect->id);
	}

	/**
	 * Block a user.
	 *
	 * @param $user_to_block
	 * @param $user_id
	 * @return mixed
	 */
	public function block($user_to_block, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_block = $this->findByUsername($user_to_block);

		if ( ! $user_to_block->isBlockedBy($user))
		{
			$user = $user->blockages()->attach($user_to_block->id);
		}

		return $user;
	}

	/**
	 * Unblock a user
	 *
	 * @param $user_to_unblock
	 * @param $user_id
	 * @return mixed
	 */
	public function unblock($user_to_unblock, $user_id)
	{
		$user = $this->findById($user_id);

		$user_to_unblock = $this->findByUsername($user_to_unblock);

		return $user->blockages()->detach($user_to_unblock->id);
	}

	public function getProfile($username)
	{
		$user = $this->findByUsername($username);

		$user->raise(new ProfileVisited($user));

		return $user;
	}

	public function registerVisitation($user)
	{
		if (Auth::id() == $user->id)
		{
			return;
		}

		ProfileVisit::visit([
			'visitor_id' => Auth::user()->id,
			'visited_id' => $user->id,
         ]);
	}

	public function update(
		$user,
		$first_name,
		$last_name,
		$username,
		$email,
		$bio,
		$avatar_id,
		$contact_information
	)
	{
		if ($user->email != $email)
		{
			$this->requestEmailChange($user, $email);
		}

		$user->first_name = $first_name;

		$user->last_name = $last_name;

		$user->username = $username;

		$user->bio = $bio;

		if ($avatar_id)
		{
			$user->avatar_id = $avatar_id;
		}

		$user->save();

		$user->contactInformation()->delete();

		foreach($contact_information as $info)
		{
			if ($info['text'] && $info['type_id'])
			{
				$ci = new ContactInformation([
					'kind_id' => $info['type_id'],
					'info' => $info['text']
				]);

				$user->contactInformation()->save($ci);
			}
		}

		return $user;
	}

	/**
	 * @param $user
	 * @param $email
	 * @return void
	 */
	private function requestEmailChange($user, $email)
	{
		$data = ['user' => $user, 'email' => $email];

		if ($emailChange = EmailChange::where('user_id', $user->id)->where('email', $email)->first())
		{
			Flash::error(t('paragraphs.email-change-already-requested'));
		}
		else
		{
			$emailChange = EmailChange::create(
				[
					'user_id' => $user->id,
					'email' => $email,
					'token' => Uuid::uuid4()
				]
			);

		}

		$data['email_change'] = $emailChange;

		$user->raise(new EmailChangeRequested($data));
	}

	public function sendEmailChangeEmail($data)
	{
		$data = array_merge(
			$data,
			[
				'link' => route('email.change', [$data['email_change']->token]),
				'report-link' => route('email.change.report', [$data['email_change']->token]),
			]
		);

		Mailer::send(
			'emails.users.change-email-current-address',
			$data['user'],
			t('captions.authorize-email-change'),
			$data
		);

		Flash::warning(t('paragraphs.email-change-message-sent'));

		$data['user']->raise(new EmailChangeMessageSent($data));
	}

	public function attachFile($id, $originalName, $user_id)
	{
		return $id;
	}

}
