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
            $this->assertTrue(empty($response["errors"]) || !arrayHasKey($response, "errors"));
        }
    }

    /**
     * @test
     */
    public function minParams() {
        $response = $this->client->artistRead(["id" => "KoO4"]);
        $this->assertArrayHasKey("id", $response);
    }

    /**
     * @test
     */
    public function icludeImages() {
        $response = $this->client->artistRead(["id" => "KoO4", "incl_images" => false]);
        $this->assertArrayNotHasKey("images", $response);
    }

    /**
     * @test
     */
    public function icludeAlsoLiked() {
        $response = $this->client->artistRead(["id" => "KoO4", "incl_also_liked" => true]);
        $this->assertArrayHasKey("fansAlsoLiked", $response);
    }

    /**
     * @test
     */
    public function fullDescription() {
        $response = $this->client->artistRead(["id" => "KoO4", "full_description" => false]);
        $short_desc = $response["description"];

        $response = $this->client->artistRead(["id" => "KoO4", "full_description" => true]);
        $full_desc = $response["description"];

        $this->assertGreaterThan(strlen($short_desc), strlen($full_desc));
    }
}