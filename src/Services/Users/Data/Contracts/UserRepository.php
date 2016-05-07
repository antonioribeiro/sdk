<?php

namespace PragmaRX\Sdk\Services\Users\Data\Contracts;

interface UserRepository
{
	public function save($user);

	public function getPaginated($howMany = 25);

	public function findByUsername($username);

	public function findById($id);

	public function findByEmail($email);

	public function activate($email, $token);

	public function sendUserActivationEmail($user);

	public function sendEmail($user, $view, $subject, $data = null);

	public function checkAndCreateActivation($user);

	public function checkActivationByEmail($email);

	public function update(
		$user,
		$first_name,
		$last_name,
		$username,
		$email,
		$bio,
		$avatar_id,
		$contact_information
	);

	public function requestEmailChange($user, $email);

	public function sendEmailChangeEmail($data);

	public function attachFile($id, $originalName, $user_id);

	public function changeLocale($user, $locale);

	public function findByCredentials($credentials);

	public function authenticate($credentials);

	public function findAuthenticatableByCredentials($credentials);

	public function checkTwoFactorAuthentication($user);

	public function create2FASecrets($user);

	public function sendPasswordReminder($user);

	public function resetPassword($email, $username = null);

	public function sendPasswordReminderEmail($user, $token);

	public function updatePassword($email, $password, $token);

	public function sendPasswordUpdatedEmail($user);

	public function updateSettings($user, $input);

	public function createNonAccount($email, $first_name, $last_name);

	public function isActivated($user);

	public function find($user);

	public function deleteUser($userId);
}
