<?php

namespace PragmaRX\SDK\Users;

use Activation;
use PragmaRX\SDK\Mailer\Mailer;
use Laracasts\Flash\Flash;

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
		return User::with(['statuses' => function($query)
		{
			$query->latest();
		}])->where('username', $username)->first();
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
	 * @param $user_to_follow_id
	 * @param $user_id
	 * @return mixed
	 */
	public function follow($user_to_follow_id, $user_id)
	{
		$user = $this->findById($user_id);

		return $user->following()->attach($user_to_follow_id);
	}

	/**
	 * Unfollow a user.
	 *
	 * @param $user_to_unfollow_id
	 * @param $user_id
	 * @return mixed
	 */
	public function unfollow($user_to_unfollow_id, $user_id)
	{
		$user = $this->findById($user_id);

		return $user->following()->detach($user_to_unfollow_id);
	}
}
