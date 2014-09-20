<?php
namespace Ents24\Tests\Api;

use Ents24\Api\Client;
use Ents24\Api\Session;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class SessionTest extends PHPUnit_Framework_TestCase
{
    private $client;
    private $session;
    private $event;
    private $request;
    private $response;

    public function setUp()
    {
        parent::setUp();
        $this->client = Client::factory();
        $this->event = new Event;
        $this->session = new Session;
        $this->event['request'] = new Request(null, null, []);
        $this->event['response'] = new Response(null);
    }

    /**
     * @test
     */
    public function addsAuthorizationHeaderToRequest()
    {
        $this->session->setAccessToken('qwertyuiop');
        $this->session->onRequestBeforeSend($this->event);
        $this->assertEquals(
            'qwertyuiop',
            $this->event['request']->getHeader('Authorization')
        );
    }
}
