--TEST--
Test index route
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require_once 'vendor/autoload.php';

$client = new GuzzleHttp\Client(['base_uri' => getenv('DOMAIN')]);

$response = $client->request('GET', '/');

echo $response->getStatusCode()."\n";

echo $response->getBody();

?>
--EXPECT--
200
{"description":"RESTfull API using Silex and JWT","version":"1.0.0"}