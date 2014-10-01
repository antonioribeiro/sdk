<?php

namespace PragmaRX\Sdk\Services\Users\Data\Repositories;

use PragmaRX\Sdk\Services\Connect\Data\Entities\Connection;
use PragmaRX\Sdk\Services\Security\Events\TwoFactorEmailDisableRequested;
use PragmaRX\Sdk\Services\Security\Events\TwoFactorEmailEnableRequested;
use PragmaRX\Sdk\Services\Security\Exceptions\ExpiredToken;
use PragmaRX\Sdk\Services\Security\Exceptions\InvalidCode;
use Rhumsaa\Uuid\Uuid;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidEmail;
use PragmaRX\Sdk\Services\ContactInformation\Data\Entities\ContactInformation;
use PragmaRX\Sdk\Services\EmailChanges\Data\Entities\EmailChange;
use PragmaRX\Sdk\Services\EmailChanges\Events\EmailChangeMessageSent;
use PragmaRX\Sdk\Services\EmailChanges\Events\EmailChangeRequested;
use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;
use PragmaRX\Sdk\Services\Mailer\Service\Mailer;
use PragmaRX\Sdk\Services\Profiles\Events\ProfileVisited;
use PragmaRX\Sdk\Services\ProfilesVisits\Data\Entities\ProfileVisit;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;

use PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidAuthenticationCode;
use PragmaRX\Sdk\Core\Exceptions\InvalidRequest;
use PragmaRX\Sdk\Core\Exceptions\InvalidToken;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;

use Input;
use Activation;
use Flash;
use Auth;
use Sentinel;
use Carbon;
use Session;
use Google2FA;

class UserRepository {

	const TOKEN_LIFETIME = 10;

	private $secretCodes = [];

	private $twoFactorTypes = ['google', 'email', 'sms'];

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
			$connection = new Connection();

			$connection->requestor_id = $user->id;

			$connection->requested_id = $user_to_connect->id;

			$connection->save();
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

		$connection = $user->getConnectionTo($user_to_disconnect->id);

		$connection->delete();

		return $user;
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
			t('paragraphs.authorize-email-change'),
			$data
		);

		Flash::warning(t('paragraphs.email-change-message-sent'));

		$data['user']->raise(new EmailChangeMessageSent($data));
	}

	public function attachFile($id, $originalName, $user_id)
	{
		return $id;
	}

	public function changeLocale($user, $locale)
	{
		$user->locale = $locale;

		$user->save();
	}

	public function findByCredentials($credentials)
	{
		if ($user = Sentinel::findByCredentials($credentials))
		{
			if ( ! Sentinel::getUserRepository()->validateCredentials($user, $credentials))
			{
				$user = false;
			}
		}

		return $user;
	}

	public function authenticate($credentials)
	{
		$user = $this->findAuthenticatableByCredentials($credentials);

		try
		{
			$next = $this->isTwoFactorEnabled($user) ? 'two-factor' : false;

			// Will only login if there is no two factor auth involved

			Auth::authenticate(
				$user,
				$credentials['remember'],
				! $this->isTwoFactorEnabled($user)
			);

			$user->raise(new UserWasAuthenticated($user));
		}
		catch (NotActivatedException $exception)
		{
			$this->checkActivationByEmail($credentials['email']);

			throw new NotActivatedException();
		}

		return ['user' => $user, 'next' => $next];
	}

	private function findAuthenticatableByCredentials($credentials)
	{
		if ( ! $user = $this->findByCredentials($credentials))
		{
			if ($this->findByEmail($credentials['email']))
			{
				throw new InvalidPassword();
			}

			throw new InvalidEmail();
		}

		return $user;
	}

	public function checkTwoFactorAuthentication($user)
	{
		if ( ! $this->isTwoFactorEnabled($user))
		{
			return;
		}

		$this->createTwoFactorTokenForuser($user);

		$this->sendTwoFactorEmailToken($user);

		$this->sendTwoFactorSmsToken($user);

		return 'two-factor';
	}

	public function create2FASecrets($user)
	{
		$user->two_factor_recovery_code_a = Uuid::uuid4();
		$user->two_factor_recovery_code_b = Uuid::uuid4();

		$user->two_factor_google_secret_key = Google2FA::generateSecretKey(32);

		$user->save();
	}

	private function createTwoFactorTokenForuser($user)
	{
		$user->two_factor_google_token = (string) Uuid::uuid4();
		$user->two_factor_google_token_created_at = \Carbon\Carbon::now();

		$user->two_factor_sms_secret_key = $this->createTypableSecret();
		$user->two_factor_sms_token = (string) Uuid::uuid4();
		$user->two_factor_sms_token_created_at = \Carbon\Carbon::now();

		$user->two_factor_email_secret_key = $this->createTypableSecret();
		$user->two_factor_email_token = (string) Uuid::uuid4();
		$user->two_factor_email_token_created_at = \Carbon\Carbon::now();

		$user->save();
	}

	public function authenticateViaTwoFactor(
		$user_id,
		$remember,
		$authentication_code,
		$two_factor_google_token,
		$two_factor_sms_token,
		$two_factor_email_token
	)
	{
		$user = $this->findById($user_id);

		$this->validateTwoFactorTokens(
			$user,
			$two_factor_google_token,
			$two_factor_sms_token,
			$two_factor_email_token
		);

		$this->validateTwoFactorCode($user, $authentication_code);

		$this->invalidateTwoFactorTokens($user);

		Sentinel::login($user, $remember);

		return $user;
	}

	public function validateTwoFactorToken($user, $kind, $token)
	{
		if ( ! $user)
		{
			throw new InvalidRequest();
		}

		return $this->checkTwoFactorToken($user, $kind, $token, true, false);
	}

	public function verifyGoogleCode($user, $authentication_code, $throwException = true)
	{
		if ( ! Google2FA::verifyKey($user->two_factor_google_secret_key, $authentication_code))
		{
			if ($throwException)
			{
				throw new InvalidAuthenticationCode();
			}

			return false;
		}

		return true;
	}

	public function getUserFromTwoFactorRequest()
	{
		if ( ! $user = Session::get('user'))
		{
			if ($user_id = Input::old('user_id'))
			{
				$user = $this->findById($user_id);
			}
		}

		return $user;
	}

	public function toggleTwoFactorGoogle($user)
	{
		$user->two_factor_google_enabled = ! $user->two_factor_google_enabled;

		$user->save();

		return $user;
	}

	private function isTwoFactorEnabled($user)
	{
		return $user->two_factor_google_enabled ||
				$user->two_factor_sms_enabled   ||
				$user->two_factor_email_enabled;
	}

	public function requestToggleTwoFactorEmail($user)
	{
		$user = $this->createTwoFactorEmailToken($user);

		if ($user->two_factor_email_enabled)
		{
			$user->raise(new TwoFactorEmailEnableRequested($user));
		}
		else
		{
			$user->raise(new TwoFactorEmailDisableRequested($user));
		}

		return $user;
	}

	private function createTwoFactorEmailToken($user)
	{
		$token = $this->createTypableSecret();

		$user->two_factor_email_secret_key = $token;

		$user->save();

		return $user;
	}

	public function sendEmailToggleTwoFactorEmail($user)
	{
		$data = [
			'link' => route('security.email.toggle', [$user->two_factor_email_secret_key]),
		];

		Mailer::send(
			'emails.users.authorize-two-factor-email',
			$user,
			t('paragraphs.authorize-two-factor-email'),
			$data
		);

		Flash::message(t('paragraphs.autorization-link-sent'));
	}

	public function toggleTwoFactorEmail($user, $code)
	{
		$this->checkTwoFactorCode($user, 'email', $code);

		$user->two_factor_email_enabled = ! $user->two_factor_email_enabled;

		$user->save();

		return $user;
	}

	public function checkTwoFactorToken($user, $type, $code, $checkEnabled = false, $throwException = true)
	{
		if ($checkEnabled)
		{
			if ( ! $user->{'two_factor_'.$type.'_enabled'})
			{
				return false;
			}
		}

		if ($user->{'two_factor_'.$type.'_token'} !== $code)
		{
			if ($throwException)
			{
				throw new InvalidToken();
			}

			return false;
		}

		if (Carbon::now()->diffInMinutes(Carbon::parse($user->{'two_factor_'.$type.'_token_created_at'})) > static::TOKEN_LIFETIME)
		{
			throw new ExpiredToken();
		}

		return true;
	}

	private function createTypableSecret()
	{
		do
		{
			$secret = substr(strtoupper(str_replace('-', '', Uuid::uuid4())), 0, 6);
		} while (in_array($secret, $this->secretCodes));

		return $secret;
	}

	private function sendTwoFactorEmailToken($user)
	{
		if ( ! $user->two_factor_email_enabled)
		{
			return;
		}

		Mailer::send(
			'emails.users.two-factor-token',
			$user,
			t('paragraphs.here-is-your-code') . ' ' . $user->two_factor_email_secret_key
		);

		Flash::message(t('paragraphs.authentication-code-sent'));
	}

	private function sendTwoFactorSmsToken($user)
	{
		// there is no sms yet
	}

	private function validateTwoFactorTokens($user, $two_factor_google_token, $two_factor_sms_token, $two_factor_email_token)
	{
		foreach ($this->twoFactorTypes as $type)
		{
			$this->checkTwoFactorToken($user, $type, ${'two_factor_'.$type.'_token'}, true);
		}
	}

	private function validateTwoFactorCode($user, $code, $throwException = true)
	{
		$valid = false;

		foreach ($this->twoFactorTypes as $type)
		{
			$valid = $valid || $this->checkTwoFactorCode($user, $type, $code);
		}

		if ( ! $valid && $throwException)
		{
			throw new InvalidCode();
		}

		return $valid;
	}

	public function checkTwoFactorCode($user, $type, $code)
	{
		if ($type == 'google')
		{
			return $this->verifyGoogleCode($user, $code, false);
		}

		return $user->{'two_factor_'.$type.'_secret_key'} == $code;
	}

	private function invalidateTwoFactorTokens($user)
	{
		foreach ($this->twoFactorTypes as $type)
		{
			$user->{'two_factor_'.$type.'_token'} = null;
			$user->{'two_factor_'.$type.'_token_created_at'} = null;
		}

		$user->save();
	}

	public function connectAction($user, $connection_id, $action)
	{
		if ( ! $connection = $user->pendingConnectionTo($connection_id))
		{
			throw new InvalidRequest();
		}

		$authorized = false;

		if ($action == 'accept')
		{
			$authorized = true;
			$column = 'authorized_at';
		}

		if ($action == 'deny')
		{
			$column = 'denied_at';
		}

		if ($action == 'postpone')
		{
			$column = 'postponed_at';
		}

		Connection::where('requestor_id', $connection->requestor_id)
					->where('requested_id', $connection->requested_id)
					->update(['authorized' => $authorized, $column => Carbon::now()]);

		return $user;
	}

}
