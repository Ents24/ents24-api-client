<?php 
namespace Ents24\Tests\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Ents24\Api\Client;

class ArtistReadEPTest extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();

        //Open credentials file.
        $credFile = fopen(__DIR__ . "/../../test_credentials.txt", "r") or die("Unable to open credential file!");

        //Get ID and secret from file.
        $clientId = trim(explode(':', fgets($credFile))[1]);
        $clientSecret = trim(explode(':', fgets($credFile))[1]);

        //Close file.
        fclose($credFile);

        $this->client = Client::factory(
            [
                "client_id"     => $clientId,
                "client_secret" => $clientSecret,
            ]
        );
    }

    /**
     * @test
     */
    public function endpointExists() {
        $response = $this->client->artistRead(["id" => "KoO4"]);
        if($response instanceof Response) {
            $this->assertTrue((!$response->getStatusCode() == "404") && (!$response->getStatusCode() == "400"));
        } else {
            if(array_key_exists("errors", $response)) {
                $this->assertEmpty($response["errors"]);
            }
        }
    }

    /**
     * @test
     */
    public function minParams() {
        $response = $this->client->artistRead(["id" => "KoO4"]);
        $this->assertEquals("Jimmy Carr", $response["name"]);
    }
}