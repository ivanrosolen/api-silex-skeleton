--TEST--
Test delete (DELETE) user route
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require_once 'vendor/autoload.php';

$client = new GuzzleHttp\Client(['base_uri' => getenv('DOMAIN')]);

$postData = ['email' => 'xuplau@gmail.com',
             'pwd'   => '3781416f382a3ddb468878de626f0c80'];

$response = $client->request('POST', '/auth/login', ['form_params' => $postData]);

$return = (string) $response->getBody();

$json  = json_decode($return);
$token = 'Bearer '.$json->jwt;

// UUID from a test_data.sql user (Xuplau21)
$uuid = 'c877f6b7-4e5f-4b53-97ba-92b7c4ab58e4';

$response = $client->request('DELETE', '/user/'.$uuid,['headers' => ['Authorization' => $token]]);

echo $response->getStatusCode()."\n";

?>
--EXPECT--
200