<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Service;

use Log;
use GuzzleHttp\Client as Guzzle;

class FacebookMessenger
{
    private $pageName;

    private $pageToken;

    // private $userProfileUrl = 'https://graph.facebook.com/v2.6/%s?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token=%s';
    private $userProfileUrl = 'https://graph.facebook.com/v2.6/%s?access_token=%s';

    private $subscribeUrl = 'https://graph.facebook.com/v2.6/:pageid/subscribed_apps?access_token=:token';

    private $messageUrl = 'https://graph.facebook.com/v2.6/me/messages?access_token=:token';

    /**
     * @var Guzzle
     */
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

    /**
     * @param $pageId
     * @param $pageToken
     * @return mixed
     */
    private function configureUrl($url, $pageToken, $pageId = null)
    {
        $url = str_replace(':pageid', $pageId, $url);
        $url = str_replace(':token', $pageToken, $url);

        return $url;
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
        return $this->processResponse($this->guzzle->get($url));
    }

    private function guzzlePost($url, $data = null)
    {
        return $this->processResponse($this->guzzle->post($url, $data));
    }

    private function instantiateGuzzle()
    {
        $this->guzzle = new Guzzle();
    }

    /**
     * @param $response
     * @return array|mixed
     */
    private function processResponse($response)
    {
        $result = json_decode((string) $response->getBody(), true) ?: [];

        $result['status_code'] = $response->getStatusCode();

        $result['success'] = $response->getStatusCode() == 200;

        if (! $result['success'])
        {
            Log::error('GUZZLE ERROR');
            Log::error($response->getBody());
        }

        return $result;
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

    public function sendMessage($recipientId, $text, $pageName, $pageToken)
    {
        $url = $this->configureUrl($this->messageUrl, $pageToken);

        $data = [
            'recipient' => [
                'id' => $recipientId
            ],
            'message' => [
                'text' => $text
            ]
        ];

        $response = $this->guzzlePost($url, ['json' => $data]);

        return $response['success'];
    }

    public function getUserProfile($user, $bot)
    {
        $url = sprintf($this->userProfileUrl, $user->facebook_messenger_id, $bot->token);

        return $this->guzzleGet($url);
    }

    public function subscribe($pageId, $pageToken)
    {
        $url = $this->configureUrl($this->subscribeUrl, $pageToken, $pageId);

        return $this->guzzlePost($url);
    }
}
