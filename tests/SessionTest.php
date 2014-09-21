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
        $this->client = m::mock(
            'Ents24\Api\Client',
            [
                'getId' => 'id1',
                'getSecret' => 'secret1',
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
        $tokenRequest = m::mock('Guzzle\Service\Command\OperationCommand');

        $this->client
            ->shouldReceive('getCommand')
            ->with(
                'RequestAccessToken',
                [
                    'client_id'     => 'id1',
                    'client_secret' => 'secret1',
                ]
            )
            ->andReturn($tokenRequest);

        $tokenRequest
            ->shouldReceive('execute')
            ->andReturn(['access_token' => 'asdfghjkl']);

        $this->session->onRequestBeforeSend($this->event);
        $this->assertEquals(
            'asdfghjkl',
            $this->event['request']->getHeader('Authorization')
        );
    }

    /**
     * @test
     */
    public function doesntFetchAccessTokenForAccessTokenRequest()
    {
        $this->event['request']->setPath('/auth/token');

        $this->client
            ->shouldReceive('getCommand')
            ->with('RequestAccessToken', m::any())
            ->times(0);

        $this->session->onRequestBeforeSend($this->event);
    }
}
