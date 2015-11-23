<?php
namespace Ents24\Tests\Api;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Ents24\Api\Client;
use Ents24\Api\Session;

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
        $this->client = m::mock(
            'Ents24\Api\Client',
            [
                'client_id' => 'id1',
                'client_secret' => 'secret1',
            ]
        );
        $this->event = new Event;
        $this->session = new Session($this->client);
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

    /**
     * @test
     */
    public function fetchesAccessTokenIfAbsent()
    {
        $this->session->setAccessToken(null);

        $this->client
            ->shouldReceive('clientRequestAccessToken')
            ->times(1);

        $this->session->onRequestBeforeSend($this->event);
    }

    /**
     * @test
     */
    public function doesntFetchAccessTokenForAccessTokenRequest()
    {
        $this->event['request']->setPath('/auth/token');

        $this->client
            ->shouldReceive('clientRequestAccessToken')
            ->times(0);

        $this->session->onRequestBeforeSend($this->event);
    }

    /**
     * @test
     */
    public function doesntFetchAccessTokenForUserTokenRequest()
    {
        $this->event['request']->setPath('/auth/login');

        $this->client
            ->shouldReceive('clientRequestAccessToken')
            ->times(0);

        $this->session->onRequestBeforeSend($this->event);
    }
}
