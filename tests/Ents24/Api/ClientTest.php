<?php
namespace Ents24\Tests\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;
use PHPUnit_Framework_TestCase;
use Ents24\Api\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = Client::factory();
    }

    /**
     * @test
     */
    public function isGuzzleClient()
    {
        $this->assertTrue($this->client instanceof GuzzleClient);
    }

    /**
     * @test
     */
    public function loadsServiceDescription()
    {
        $description = $this->client->getDescription();
        $this->assertEquals("Ents24 API Client", $description->getName());
    }
}
