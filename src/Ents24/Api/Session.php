<?php
namespace Ents24\Api;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Session implements EventSubscriberInterface
{
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public static function getSubscribedEvents()
    {
        return ['request.before_send' => ['onRequestBeforeSend', 255]];
    }

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];
        $request->setHeader('Authorization', $this->accessToken);
    }
}
