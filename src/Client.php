<?php
namespace Ents24\Api;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Common\Event;

class Client extends GuzzleClient
{
    private $id;
    private $secret;
    private $session;
    private $description;

    public static function factory($config = [])
    {
        $config['request.options'] = ['exceptions' => false];
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

    public function getId()
    {
        return $this->id;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
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
            return $response;
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
            return $response;
        } else {
            throw new InvalidArgumentException(
                "No client ID and/or secret found.
                 Please set the client's credentials before authenticating."
            );
        }
    }

    public function venueList($parameters = []) {
        $request = $this->getCommand('VenueList', $parameters);
        return $request->execute();
    }

	public function venueRead($parameters = []) {
        $request = $this->getCommand('VenueRead', $parameters);
        return $request->execute();
    }

    public function venueEvents($parameters = []) {
        $request = $this->getCommand('VenueEvents', $parameters);
        return $request->execute();
    }

    public function venueImage($parameters = []) {
        $request = $this->getCommand('VenueImage', $parameters);
        return $request->execute();
    }

    public function venueWidget($parameters = []) {
        $request = $this->getCommand('VenueWidget', $parameters);
        return $request->execute();
    }

    public function artistList($parameters = []) {
        $request = $this->getCommand('ArtistList', $parameters);
        return $request->execute();
    }

    public function artistRead($parameters = []) {
        $request = $this->getCommand('ArtistRead', $parameters);
        return $request->execute();
    }

    public function artistEvents($parameters = []) {
        $request = $this->getCommand('ArtistEvents', $parameters);
        return $request->execute();
    }

    public function artistImage($parameters = []) {
        $request = $this->getCommand('ArtistImage', $parameters);
        return $request->execute();
    }

    public function artistWidget($parameters = []) {
        $request = $this->getCommand('ArtistWidget', $parameters);
        return $request->execute();
    }

    public function eventList($parameters = []) {
        $request = $this->getCommand('EventList', $parameters);
        return $request->execute();
    }

    public function eventRead($parameters = []) {
        $request = $this->getCommand('EventRead', $parameters);
        return $request->execute();
    }

    public function eventGenres($parameters = []) {
        $request = $this->getCommand('EventGenres', $parameters);
        return $request->execute();
    }

    public function eventImage($parameters = []) {
        $request = $this->getCommand('EventImage', $parameters);
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

    public function userTrackingUpdate($parameters = []) {
        $request = $this->getCommand('UserTrackingUpdate', $parameters);
        return $request->execute();
    }

    public function locationSearch($parameters = []) {
        $request = $this->getCommand('LocationSearch', $parameters);
        return $request->execute();
    }

    public function locationWidget($parameters = []) {
        $request = $this->getCommand('LocationWidget', $parameters);
        return $request->execute();
    }

	public function locationWidgetPage($parameters = []) {
		$request = $this->getCommand('LocationWidgetPage', $parameters);
		return $request->execute();
	}
}
