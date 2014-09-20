<?php
namespace Ents24\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;

class Client extends GuzzleClient
{
    public static function factory($config = [])
    {
        $client = parent::factory($config);

        $descriptionPath = realpath(__DIR__ . '/../../../api/index.json');
        $description = ServiceDescription::factory($descriptionPath);

        $session = new Session($config['client_id'], $config['client_secret']);

        $client->setDescription($description);
        $client->setBaseUrl($description->getData('base_url'));
        $client->addSubscriber($session);

        return $client;
    }
}
