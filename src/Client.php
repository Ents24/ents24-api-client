<?php
namespace Ents24\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;

class Client extends GuzzleClient
{
    private $id;
    private $secret;
    private $session;

    public static function factory($config = [])
    {
        $client = parent::factory($config);

        $descriptionPath = realpath(__DIR__ . '/../api/index.json');
        $description = ServiceDescription::factory($descriptionPath);

        $client->setSession(new Session($client));
        $client->setId($config['client_id']);
        $client->setSecret($config['client_secret']);
        $client->setDescription($description);
        $client->addSubscriber($client->getSession());

        return $client;
    }

    public function setSession($session) {
        $this->session = $session;
    }

    public function getSession() {
        return $this->session;
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

    public function clientRequestAccessToken() {
        if($this->id && $this->secret) {
            $request = $this->getCommand('ClientRequestAccessToken',
                [
                    'client_id' => $this->id,
                    'client_secret' => $this->secret
                ]
            );
            $response = $request->execute();
            $this->session->setAccessToken($response['access_token']);
        } else {
            throw new InvalidArgumentException(
                "No client ID and/or secret found.
                 Please set the client's credentials before authenticating."
            );
        }
    }

    public function userRequestAccessToken($username, $password) {
        if($this->id && $this->secret) {
            $request = $this->getCommand('UserRequestAccessToken',
                [
                    'client_id' => $this->id,
                    'client_secret' => $this->secret,
                    'username' => $username,
                    'password' => $password
                ]
            );
            $response = $request->execute();
            $this->session->setAccessToken($response['access_token']);
        } else {
            throw new InvalidArgumentException(
                "No client ID and/or secret found.
                 Please set the client's credentials before authenticating."
            );
        }
    }
    
    public function venueList($args) {
        $request = $this->getCommand('VenueList', $args);
        return $request->execute();
    }
	
	public function venueRead($args) {
        $request = $this->getCommand('VenueRead', $args);
        return $request->execute();
    }

    public function venueEvents($args) {
        $request = $this->getCommand('VenueEvents', $args);
        return $request->execute();
    }

    public function venueImage($args) {
        $request = $this->getCommand('VenueImage', $args);
        return $request->execute();
    }

    public function artistList($args) {
        $request = $this->getCommand('ArtistList', $args);
        return $request->execute();
    }
    
    public function artistRead($args) {
        $request = $this->getCommand('ArtistRead', $args);
        return $request->execute();
    }

    public function artistEvents($args) {
        $request = $this->getCommand('ArtistEvents', $args);
        return $request->execute();
    }

    public function artistImage($args) {
        $request = $this->getCommand('ArtistImage', $args);
        return $request->execute();
    }

    public function eventList($args) {
        $request = $this->getCommand('EventList', $args);
        return $request->execute();
    }
    
    public function eventRead($args) {
        $request = $this->getCommand('EventRead', $args);
        return $request->execute();
    }

    public function eventGenres($args) {
        $request = $this->getCommand('EventGenres', $args);
        return $request->execute();
    }

    public function eventImage($args) {
        $request = $this->getCommand('EventImage', $args);
        return $request->execute();
    }

    public function userTrackedArtists() {
        $request = $this->getCommand('UserTrackedArtists');
        return $request->execute();
    }

    public function userTrackedEvents() {
        $request = $this->getCommand('UserTrackedEvents');
        return $request->execute();
    }

    public function userTrackedVenues() {
        $request = $this->getCommand('UserTrackedVenues');
        return $request->execute();
    }

    public function userTrackingUpdate($args) {
        $request = $this->getCommand('UserTrackingUpdate', $args);
        return $request->execute();
    }

    public function locationSearch($args) {
        $request = $this->getCommand('LocationSearch', $args);
        return $request->execute();
    }
}
