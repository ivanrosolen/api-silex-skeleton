--TEST--
Test create (POST) user route
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

$postData = ['name'  => 'Test',
             'email' => 'test'.time().'@gmail.com',
             'pwd'   => '3781416f382a3ddb468878de626f0c80'];

$response = $client->request('POST', '/user',['headers' => ['Authorization' => $token],
                                               'form_params' => $postData]);

echo $response->getStatusCode()."\n";

$return = (string) $response->getBody();

$json        = json_decode($return);
$json->hash  = '%s';
$json->email = '%s';

echo json_encode($json);

?>
--EXPECT--
201
{"hash":"%s","name":"Test","email":"%s"}