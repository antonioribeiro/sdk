<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

use Illuminate\Auth\UserTrait;
use Illuminate\Contracts\Auth\User as UserContract;
use Illuminate\Support\Facades\Hash;

use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use PragmaRX\Sdk\Core\Traits\ReloadableTrait;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidActivationToken;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserActivationNotFound;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Registration\Events\UserRegistered;

use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Presenter\PresentableTrait;

use Activation;
use Auth;
use PragmaRX\Sdk\Services\Settings\Data\Entities\Setting;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\BlockableTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\ConnectableTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\FollowableTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\VisitableTrait;
use Rhumsaa\Uuid\Uuid;

class User extends CartalystUser implements UserContract {

	use
		FollowableTrait,
		ConnectableTrait,
		BlockableTrait,
		VisitableTrait,
		UserTrait,
		EventGenerator,
		PresentableTrait,
		ReloadableTrait,
		IdentifiableTrait;

	protected $fillable = ['id', 'username', 'email', 'password', 'first_name', 'last_name'];

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
			'id' => (string) Uuid::uuid4(),
		    'email' => $email,
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

	public function avatar()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Files\Data\Entities\File', 'avatar_id');
	}

	public function twoFactorType()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\TwoFactor\Data\Entities\TwoFactorType', 'two_factor_type_id');
	}

	public function inviter()
	{
		return $this->belongsTo(static::class, 'inviter_id');
	}

	public function isConnectedByInvitation(User $user)
	{
		return
			($this->inviter_id && $this->inviter_id == $user->id) ||
			($user->inviter_id && $user->inviter_id == $this->id);
	}

	public function settings()
	{
		$this->checkUserSettings();

		return $this->hasOne('PragmaRX\Sdk\Services\Settings\Data\Entities\Setting', 'user_id');
	}

	private function checkUserSettings()
	{
		if ( ! $this->hasOne(Setting::class, 'user_id')->first())
		{
			$settings = new Setting();

			$this->hasOne(Setting::class, 'user_id')->save($settings);
		}
	}

	public function clients()
	{
		return $this->hasMany('PragmaRX\Sdk\Services\Clients\Data\Entities\Client', 'provider_id');
	}

	public function clientsByName()
	{
		return $this
				->clients()
				->orderBy('first_name')
				->orderBy('last_name');
	}

}
