<?php

namespace PragmaRX\SDK\Users;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Hash;
use PragmaRX\SDK\Accounts\Exceptions\InvalidActivationToken;
use PragmaRX\SDK\Accounts\Exceptions\UserActivationNotFound;
use PragmaRX\SDK\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\SDK\Users\FollowableTrait;
use PragmaRX\SDK\Registration\Events\UserRegistered;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;
use Activation;
use Auth;

class User extends CartalystUser implements UserInterface, RemindableInterface {

	use FollowableTrait, UserTrait, RemindableTrait, EventGenerator, PresentableTrait;

	protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name'];

	protected $presenter = 'PragmaRX\SDK\Users\UserPresenter';

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
		return $this->hasMany('PragmaRX\SDK\Statuses\Status');
	}

	public function contactInformation()
	{
		return $this->hasMany('PragmaRX\SDK\ContactInformation\ContactInformation');
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

}
