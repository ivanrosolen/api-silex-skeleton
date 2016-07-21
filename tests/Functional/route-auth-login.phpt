--TEST--
Test auth login route
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require_once 'vendor/autoload.php';

$client = new GuzzleHttp\Client(['base_uri' => getenv('DOMAIN')]);

$postData = ['email' => 'xuplau@gmail.com',
             'pwd'   => '3781416f382a3ddb468878de626f0c80'];

$response = $client->request('POST', '/auth/login', ['form_params' => $postData]);

echo $response->getStatusCode()."\n";

$return = (string) $response->getBody();

$json              = json_decode($return);
$json->jwt         = '%s.%s.%s';
$json->renew_token = '%s';

echo json_encode($json);

?>
--EXPECT--
200
{"jwt":"%s.%s.%s","renew_token":"%s","name":"Xuplau","email":"xuplau@gmail.com","hash":"092227be-8d61-49c1-9bea-04f977af0f01"}