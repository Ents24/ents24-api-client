<?php
namespace Ents24\Api;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Session implements EventSubscriberInterface
{
    private $client;
    private $accessToken;

    public static function getSubscribedEvents()
    {
        return ['request.before_send' => ['onRequestBeforeSend', 255]];
    }

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function onRequestBeforeSend(Event $event)
    {
        if ($this->accessToken === null) {
            $tokenRequest = $this->client->getCommand(
                'RequestAccessToken',
                [
                    'client_id'     => $this->client->getId(),
                    'client_secret' => $this->client->getSecret(),
                ]
            );
            $tokenResponse = $tokenRequest->execute();
            $this->accessToken = $tokenResponse['access_token'];
        }

        $request = $event['request'];
        $request->setHeader('Authorization', $this->accessToken);
    }
}
