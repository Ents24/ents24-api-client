<?php
namespace Ents24\Tests\Api;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;
use Ents24\Api\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = Client::factory(
            [
                'client_id'     => 'id1',
                'client_secret' => 'secret1',
            ]
        );
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
