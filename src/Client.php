<?php
namespace Ents24\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;

class Client extends GuzzleClient
{
    private $id;
    private $secret;

    public static function factory($config = [])
    {
        $client = parent::factory($config);

        $descriptionPath = realpath(__DIR__ . '/../api/index.json');
        $description = ServiceDescription::factory($descriptionPath);

        $session = new Session($client);

        $client->setId($config['client_id']);
        $client->setSecret($config['client_secret']);
        $client->setDescription($description);
        $client->setBaseUrl($description->getData('base_url'));
        $client->addSubscriber($session);

        return $client;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret()
    {
        return $this->secret;
    }
}
