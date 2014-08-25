<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

use Illuminate\Auth\UserTrait;
use Illuminate\Contracts\Auth\User as UserContract;
use Illuminate\Contracts\Auth\Remindable as RemindableContract;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Support\Facades\Hash;

use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidActivationToken;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserActivationNotFound;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Registration\Events\UserRegistered;

use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

use Activation;
use Auth;

class User extends CartalystUser implements UserContract, RemindableContract {

	use
		FollowableTrait,
		ConnectableTrait,
		BlockableTrait,
		VisitableTrait,
		UserTrait,
		RemindableTrait,
		EventGenerator,
		PresentableTrait;

	protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name'];

	protected $presenter = 'PragmaRX\Sdk\Services\Users\Data\Entities\UserPresenter';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * Register a new user
	 *
	 * @param $first_name
	 * @param $email
	 * @param $password
	 * @return static
	 */
	public static function register($username, $email, $password, $first_name, $last_name)
	{
		$credentials = [
		    'email'    => $email,
		    'password' => $password,
		    'first_name' => $first_name,
		    'last_name' => $last_name,
		    'username' => $username,
		];

		$user = Auth::register($credentials);

		$user->raise(new UserRegistered($user));

		return $user;
	}

	public static function activate($email, $token)
	{
		$user = static::where('email', $email)->first();

		if (Activation::completed($user))
		{
			throw new UserAlreadyActivated();
		}

		if ( ! Activation::exists($user))
		{
			throw new UserActivationNotFound();
		}

	    if ( ! Activation::complete($user, $token))
	    {
		    throw new InvalidActivationToken();
	    }

		return $user;
	}

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = substr($password, 0, 4) !== '$2y$'
										? Hash::make($password)
										: $password;
	}

	public function statuses()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Statuses\Data\Entities\Status');
	}

	public function contactInformation()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\ContactInformation\Data\Entities\ContactInformation');
	}

	/**
	 * @param $current
	 * @return bool|null
	 */
	public function is($current)
	{
		if (is_null($current) || ! $current)
		{
			return false;
		}

		return $this->id === $current->id;
	}

	public function getActivateAccountToken()
	{
		if ( ! $activation = Activation::exists($this))
		{
			return false;
		}

		return $activation->code;
	}

	public function filterRelationBlockages($relation, $otherColumn, $userColumn)
	{
		if ($blocked = $this->blockages()->lists('blocked_id'))
		{
			$relation->whereNotIn($otherColumn, $blocked);
		}

		if ($blocked = $this->blockedBy()->lists('blocker_id'))
		{
			$relation->whereNotIn($userColumn, $blocked);
		}
	}
}
