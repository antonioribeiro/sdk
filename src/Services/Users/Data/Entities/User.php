<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities;

use DB;
use Auth;
use Activation;
use Carbon\Carbon;
use Rhumsaa\Uuid\Uuid;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use PragmaRX\Sdk\Core\Traits\ReloadableTrait;
use PragmaRX\Sdk\Core\Traits\IdentifiableTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\User as UserContract;
use PragmaRX\Sdk\Services\Bus\Events\EventGenerator;
use PragmaRX\Sdk\Services\Presenter\PresentableTrait;
use PragmaRX\Sdk\Services\Users\Events\UserGotOnline;
use PragmaRX\Sdk\Services\Online\Data\Entities\Online;
use PragmaRX\Sdk\Services\Clients\Data\Entities\Client;
use PragmaRX\Sdk\Services\Settings\Data\Entities\Setting;
use PragmaRX\Sdk\Core\Database\Eloquent\User as SdkUser;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramUser;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\BlockableTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\VisitableTrait;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidActivationToken;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserActivationNotFound;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\FollowableTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\ConnectableTrait;
use PragmaRX\Sdk\Services\Registration\Service\Facade as Registration;
use PragmaRX\Sdk\Services\Users\Data\Presenters\User as UserPresenter;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\BusinessableTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use PragmaRX\Sdk\Services\Users\Data\Entities\Traits\PermissionableTrait;

class User extends SdkUser implements CanResetPassword
{
	use
		FollowableTrait,
		ConnectableTrait,
		BlockableTrait,
		VisitableTrait,
		Authenticatable,
		EventGenerator,
		PresentableTrait,
		ReloadableTrait,
		IdentifiableTrait,
		CanResetPasswordTrait,
		PermissionableTrait,
		BusinessableTrait;

	protected $fillable = ['id', 'username', 'email', 'password', 'first_name', 'last_name'];

	protected $presenter = UserPresenter::class;

    protected $casts = [
        'id' => 'string',
    ];

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
     * The dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

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

		$user = Registration::register($credentials);

		return $user;
	}

	public static function activate($email, $token, $force = false)
	{
		$user = static::where('email', $email)->first();

		if (Activation::completed($user)) {
            if ($force) {
                return $user;
            }

			throw new UserAlreadyActivated();
		}

		if ( ! Activation::exists($user))
		{
			throw new UserActivationNotFound();
		}

	    if ( ! Activation::complete($user, $token, $force))
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
		return $this->hasMany('PragmaRX\Sdk\Services\ContactInformation\Data\Entities\ContactInformation', 'user_id');
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

	public function getClients()
	{
		return Client::where('providers_clients.provider_id', $this->id);

//		return	$this
//				->belongsToMany('PragmaRX\Sdk\Services\Clients\Data\Entities\Client', 'providers_clients', 'providers_client.provider_id', 'providers_client.client_id');
	}

	public function getAllClients()
	{
		return $this->getClients()->get();
	}

	public function isProviderOf($id)
	{
		return $this->getClients()->where('providers_clients.client_id', $id)->first();
	}

	public function getIsActivatedAttribute()
	{
		return Activation::completed($this);
	}

	public function scopeActivated($query)
	{
		return $query->whereExists(function($query)
				{
					$query
						->select(DB::raw(1))
						->from('activations')
						->whereRaw(
							'activations.user_id = users.id' .
							' and activations.completed = true'
						);
				});
	}

	public function memberships()
	{
		return $this->morphMany('PragmaRX\Sdk\Services\Groups\Data\Entities\GroupMember', 'membership');
	}

	public function getUsersConnectedToMe()
	{
		$connections = [];

		foreach($this->connections as $connection)
		{
			$connections[] = $connection->connectedTo($this);
		}

		return app()->make(Collection::class, [$connections]);
	}

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class, 'telegram_user_id');
    }

    public function online()
    {
        if (! $online = Online::where('user_id', $this->id)->first())
        {
            $online = new Online();

            $online->user_id = $this->id;

            $online->last_seen_at = Carbon::now();

            $online->save();
        }

        return $this->belongsTo(Online::class, 'id', 'user_id');
    }

    public function getLastSeenAtAttribute()
    {
        if ($this->online)
        {
            return $this->online->last_seen_at;
        }
    }

    public function setLastSeenAtAttribute($value = null)
    {
        $now = Carbon::now();

        $value = $value ?: $now;

        $userArrivedNow = $now->diffInSeconds($this->online->last_seen_at) >= config('env.OFFLINE_USER_SECONDS');
            
        $this->online->last_seen_at = $value;

        $this->online->online = true;

        $this->online->save();
        
        if ($userArrivedNow)
        {
            event(new UserGotOnline($this));
        }
    }
}
