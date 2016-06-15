Ents24 API Client
=================

[![Code Climate](https://codeclimate.com/github/Ents24/ents24-api-client/badges/gpa.svg)](https://codeclimate.com/github/Ents24/ents24-api-client)

This is a PHP client for [Ents24's API](http://developers.ents24.com/). It's built
on the [Guzzle client framework](http://docs.guzzlephp.org/en/latest/), which
means it plays nice with [Service Docs](http://service-docs.adeslade.co.uk/).

Requirements
------------

* PHP 5.4 or above
* [Composer](https://getcomposer.org/)

Installation
------------

Add the following to the `require` section of your project's `composer.json`.

    "Ents24/ents24-api-client": "dev-master"

Add the folowing to the `repositories` section of your project's `composer.json`.

    {
      "type": "vcs",
      "url":  "https://www.github.com/Ents24/ents24-api-client.git"
    }

Run `composer install`.

Usage
-----

You need client ID and secret keys for the Ents24 API in order to make requests. You can get these [here](http://developers.ents24.com/control-panel).

Once you have credentials build a client instance using the factory and pass the credentials to it.

The Client extends the Guzzle client object. It has all of the normal Guzzle client capabilities. It is provided with a service description of the Ents24 API which we will be endeavouring to keep up to date. If you are familiar with Guzzle then go nuts.

If you are not familiar with Guzzle, don't worry. For ease of use we have provided functions on the client object each corresponding to one of our API endpoints. They all accept a key-value array which should contain the parameters you want to pass to the endpoint. To pass no parameters to an endpoint with no required parameters pass an empty array or no array at all.

For documentation of our endpoints and the parameters they accept check out our [API documentation](http://developers.ents24.com/api-reference).

This short example code with a valid client ID and secret loads a list of artists and prints the first result to
stdout.

```php
<?php
require 'vendor/autoload.php';

$client = Ents24\Api\Client::factory(
    [
        'client_id'     => 'my_client_id',
        'client_secret' => 'my_client_secret',
    ]
);

$artistList = $client->artistList(["name" => "Texas"]);
$firstArtist = current($artistList);

echo $firstArtist['name'], "\n";
echo $firstArtist['description'], "\n";
```

This code produces the following output.

> Texas  
> This Glasgow based band have been playing their mix of rock, soul and new
> country...


License
-------

This project is released under the [MIT License].

[MIT License]: http://www.opensource.org/licenses/MIT
