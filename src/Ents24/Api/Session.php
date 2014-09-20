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
        $request = $event['request'];
        $request->setHeader('Authorization', $this->accessToken);
    }
}
