<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Service;

use GuzzleHttp\Client as Guzzle;

class FacebookMessenger
{
    private $pageName;

    private $pageToken;

    // private $userProfileUrl = 'https://graph.facebook.com/v2.6/%s?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token=%s';
    private $userProfileUrl = 'https://graph.facebook.com/v2.6/%s?access_token=%s';

    private $subscribeUrl = 'https://graph.facebook.com/v2.6/:pageid/subscribed_apps?access_token=:token';

    private $guzzle;

    public function __construct($pageName = null, $pageToken = null)
    {
        $this->configurePage($pageName, $pageToken);

        $this->instantiateGuzzle();
    }

    /**
     * @param $pageName
     * @param $pageToken
     */
    public function configurePage($pageName, $pageToken)
    {
        $this->setPageName($pageName);

        $this->setPageToken($pageToken);
    }

    public function getWebhookUrl()
    {
        return route(
            'facebookMessenger.webhook.handle',
            [
                'name' => $this->pageName,
                'token' => $this->pageToken,
            ]
        );
    }

    private function guzzleGet($url)
    {
        $res = $this->guzzle->get($url);

        if ($res->getStatusCode() == 200)
        {
            return json_decode((string) $res->getBody(), true);
        }

        return [];
    }

    private function guzzlePost($url)
    {
        $res = $this->guzzle->post($url);

        if ($res->getStatusCode() == 200)
        {
            return json_decode((string) $res->getBody(), true);
        }

        return [];
    }

    private function instantiateGuzzle()
    {
        $this->guzzle = new Guzzle();
    }

    /**
     * @param mixed $pageName
     */
    public function setPageName($pageName)
    {
        if ($this->pageName !== $pageName)
        {
            $this->initialized = false;
        }

        $this->pageName = $pageName;
    }

    /**
     * @param mixed $pageToken
     */
    public function setPageToken($pageToken)
    {
        if ($this->pageToken !== $pageToken)
        {
            $this->initialized = false;
        }

        $this->pageToken = $pageToken;
    }

    public function setWebhook()
    {
        $result = $this->facebookMessenger->setWebHook($this->getWebhookUrl($this->pageName, $this->pageToken));

        return $this->description = $result->getDescription();
    }

    public function handle()
    {
        $this->facebookMessenger->handle();
    }

    public function sendMessage($chatId, $text, $pageName, $pageToken)
    {
        $this->configurePage($pageName, $pageToken);

        return FacebookMessengerRequest::sendMessage(
            [
                'text' => $text,
                'chat_id' => $chatId,
            ]
        );
    }

    public function getUserProfile($user, $bot)
    {
        $url = sprintf($this->userProfileUrl, $user->facebook_messenger_id, $bot->token);

        return $this->guzzleGet($url);
    }

    public function subscribe($pageId, $token)
    {
        $url = str_replace(':pageid', $pageId, $this->subscribeUrl);
        $url = str_replace(':token', $token, $url);

        return $this->guzzlePost($url);
    }
}
