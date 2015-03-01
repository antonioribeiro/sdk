<?php

namespace PragmaRX\Sdk\Services\Auth\Contracts;


interface Auth {

	public function check();

	public function user();

	public function guest();

	public function id();

	public function logout();

	public function authenticate($credentials, $remember = false, $login = true);

	public function register($credentials);

	public function findByCredentials($credentials);

	public function getUserRepository();

	public function login($user, $remember);

	public function createReminder($user);

	public function updatePasswordViaReminder($user, $token, $password);

	public function forceActivation($user);

	public function checkAndCreateActivation($user);

	public function hasValidCredentials($user, $credentials);

}
