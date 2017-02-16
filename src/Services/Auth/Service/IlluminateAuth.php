<?php

namespace PragmaRX\Sdk\Services\Auth\Service;

use DB;
use Hash;
use Activation;
use Carbon\Carbon;
use PragmaRX\Sdk\Core\Exceptions\InvalidToken;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use PragmaRX\Sdk\Services\Users\Jobs\SendUserActivationEmail;
use PragmaRX\Sdk\Services\Auth\Contracts\Auth as AuthContract;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;
use PragmaRX\Sdk\Services\Activation\Exceptions\UserNotActivated;

class IlluminateAuth implements AuthContract
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $lastSeenUpdated = false;

    public function __construct(UserRepository $userRepository) {
        $this->auth = app('auth');

        $this->tokens = $this->getTokenRepository();

        $this->userRepository = $userRepository;
    }

    public function check() {
        $this->updateLastSeen();

        return $this->auth->check();
    }

    private function getTokenRepository() {
        return new DatabaseTokenRepository(
            app('db')->connection(),
            app('hash'),
            config('auth.passwords.users.table'),
            config('app.key'),
            config('auth.passwords.users.expire')
        );
    }

    private function setLoggedIn($user, $isLoggedIn)
    {
        $user->last_seen_at = Carbon::now();

        $user->logged_in = $isLoggedIn;

        $user->save();
    }

    public function user() {
        $this->updateLastSeen();

        return $this->auth->user();
    }

    public function guest() {
        return $this->auth->guest();
    }

    public function id() {
        if ($user = $this->user()) {
            return $user->id;
        }

        return false;
    }

    public function logout()
    {
        $this->setLoggedIn($this->auth->user(), false);

        return $this->auth->logout();
    }

    public function authenticate($user, $remember = false, $login = true)
    {
        $this->checkActivation($user);

        if (!$login) {
            return true;
        }

        $result = $this->auth->login($user, $remember);

        $this->setLoggedIn($user, true);

        return $result;
    }

    public function register($credentials)
    {
        return $this->auth->register($credentials);
    }

    public function findByCredentials($credentials) {
        return $this->auth->getProvider()->retrieveByCredentials(
            $this->sanitizeCredentials($credentials)
        )
            ;
    }

    public function getUserRepository() {
        return $this->auth->getUserRepository();
    }

    public function login($user, $remember) {
        return $this->auth->login($user, $remember);
    }

    public function createReminder($user) {
        return $this->tokens->create($user);
    }

    public function updatePasswordViaReminder($user, $token, $password) {
        if (!$this->tokens->exists($user, $token)) {
            throw new InvalidToken;
        }

        $user->password = Hash::make($password);

        $user->save();

        $this->tokens->delete($token);

        $this->userRepository->activate($user->email, null, true); // force activation

        return true;
    }

    public function forceActivation($user) {
        $this->checkAndCreateActivation($user);

        DB::table('activations')
          ->where('user_id', $user->id)
          ->update([
                       'completed'    => true,
                       'completed_at' => Carbon::now(),
                   ])
        ;
    }

    public function checkAndCreateActivation($user) {
        if (!Activation::exists($user)) {
            Activation::create($user);

            return true;
        }

        return false;
    }

    private function sanitizeCredentials($credentials) {
        return [
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ];
    }

    public function hasValidCredentials($user, $credentials) {
        return
            !is_null($user) &&
            $this->auth->getProvider()->validateCredentials($user, $credentials);
    }

    private function checkActivation($user) {
        if ( ! Activation::activated($user)) {
            dispatch(new SendUserActivationEmail($user));

            throw new UserNotActivated();
        }
    }

    private function updateLastSeen() {
        if ($this->lastSeenUpdated) {
            return;
        }

        if ($user = $this->auth->user())
        {
            $user->last_seen_at = Carbon::now();

            $user->save();

            $this->lastSeenUpdated = true;
        }
    }
}
