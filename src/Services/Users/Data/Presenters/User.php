<?php

namespace PragmaRX\Sdk\Services\Users\Data\Presenters;

use Config;
use Avatar;
use Google2FA;
use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessRole;

class User extends Presenter {

	/**
	 * Present the link to the user's gravatar.
	 *
	 * @param int $size
	 * @return string
	 */
	public function avatar($size = 100)
	{
        if ($this->entity->telegram_user_id)
        {
            return $this->getTelegramAvatar();
        }

		return Avatar::getUrl($this->entity, $size);
	}

	public function followersCount()
	{
		$count = $this->entity->followedBy()->count();

		$plural = str_plural('Follower', $count);

		return "$count $plural";
	}

	public function connectionsCount()
	{
		$count = $this->entity->connections()->count();

		return $count;
	}

	public function getContactInfos()
	{
		return [
			[
				'kind' => 'phone',
				'info' => '21-2556-3164',
			],
			[
				'kind' => 'phone',
				'info' => '21-9-8088-2233',
			],
			[
				'kind' => 'phone',
				'info' => '21-9-8088-2234',
			],
			[
				'kind' => 'skype',
				'info' => '21-2556-3164',
			],
			[
				'kind' => 'envelope',
				'info' => $this->email,
			],
		];
	}

	public function getBio()
	{
		return $this->bio;
	}

	public function followingCount()
	{
		$count = $this->entity->following()->count();

		return "$count Following";
	}

    private function getTelegramAvatar()
    {
        $user = $this->entity->telegramUser;

        return $user->avatar->file->url;
    }

    public function statusesCount()
	{
		$count = $this->entity->statuses()->count();

		$plural = str_plural('Status', $count);

		return "$count $plural";
	}

	public function fullName()
	{
		$name = $this->first_name .
					($this->last_name ? ' ' : '') .
					$this->last_name;


		return $name ?: $this->username;
	}

	public function position()
	{
		return 'CEO, PragmaRX';
	}

	public function google2faimage()
	{
		return Google2FA::getQRCodeGoogleUrl(Config::get('app.name'), $this->email, $this->two_factor_google_secret_key);
	}

	public function clientFieldName()
	{
		return $this->settings->client_field_name
				? $this->settings->client_field_name
				: t("captions.clients");
	}

    public function isActivated($defaultYes = null, $defaultNo = null)
    {
        return $this->is_activated 
                ? ($defaultYes !== null ? $defaultYes : 'yes')
                : ($defaultNo !== null ? $defaultNo : 'no');
    }
}
