Ents24 API Client
=================

[![Build Status](https://travis-ci.org/hnrysmth/ents24-api-client.svg?branch=master)](https://travis-ci.org/hnrysmth/ents24-api-client)
[![Code Climate](https://codeclimate.com/github/hnrysmth/ents24-api-client/badges/gpa.svg)](https://codeclimate.com/github/hnrysmth/ents24-api-client)

This is a PHP client for [Ents24's API](http://docs.api.ents24.com/). It's built
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

You need client ID and secret keys for the Ents24 API in order to make requests. You can get these here: https://ents24.com/developer.

Once you have credentials build a client instance using the factory and pass the credentials to it.

This short example code loads a list of artists and prints the first result to
stdout.

```php
<?php
require 'vendor/autoload.php';

$client = Ents24\Api\Client::factory(
    [
        'client_id'     => 'qwertyuiop',
        'client_secret' => 'asdfghjkl;',
    ]
);

$listRequest = $client->getCommand('ListArtists');
$artistList = $listRequest->execute();
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
