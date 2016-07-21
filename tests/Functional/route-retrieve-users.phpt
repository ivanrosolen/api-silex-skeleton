--TEST--
Test retrieve (GET) users route
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

$response = $client->request('GET', '/users',['headers' => ['Authorization' => $token]]);

echo $response->getStatusCode()."\n";

echo $response->getBody();

?>
--EXPECT--
200
[{"hash":"092227be-8d61-49c1-9bea-04f977af0f01","name":"Xuplau","email":"xuplau@gmail.com"},{"hash":"39e00070-77df-4e03-992e-c5cf288ed836","name":"Xuplau1","email":"xuplau1@gmail.com"},{"hash":"56e1ec36-75f2-4267-968c-cf2b882f8123","name":"Xuplau2","email":"xuplau2@gmail.com"},{"hash":"18986eaf-4f23-43a8-9b9e-dd2ebec6b2dc","name":"Xuplau3","email":"xuplau3@gmail.com"},{"hash":"61da6b7c-b439-4bff-a6b3-348a00c8ab4e","name":"Xuplau4","email":"xuplau4@gmail.com"},{"hash":"943f7c5c-01d7-49a8-8ad8-1a80aa90ab07","name":"Xuplau5","email":"xuplau5@gmail.com"},{"hash":"730cec07-aa52-4dc9-8fb2-f8915bf1216a","name":"Xuplau6","email":"xuplau6@gmail.com"},{"hash":"d7690201-f8dc-4545-a4c3-f1fe2fca33d9","name":"Xuplau7","email":"xuplau7@gmail.com"},{"hash":"ce7b1c33-5603-460b-9f21-959d5f6fd334","name":"Xuplau8","email":"xuplau8@gmail.com"},{"hash":"97b118ab-ecf4-43d1-8aca-ae928848a81e","name":"Xuplau9","email":"xuplau9@gmail.com"}]
--CLEAN--
<?php
$conn = null;
?>