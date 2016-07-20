--TEST--
Test auth login route
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require 'vendor/autoload.php';

$config = new \Doctrine\DBAL\Configuration();
$dsn    = ['url' => 'sqlite:///:memory:'];
$conn   = \Doctrine\DBAL\DriverManager::getConnection($dsn, $config);

$schema = new \Doctrine\DBAL\Schema\Schema();
$myTable = $schema->createTable('user');
$myTable->addColumn('name',   'string');
$myTable->addColumn('email',  'string');
$myTable->addColumn('pwd',    'string');
$myTable->addColumn('uuid',   'string');
$myTable->addColumn('status', 'integer');

$platform = $conn->getDatabasePlatform();

$queries = $schema->toSql($platform);

$stmt = $conn->query($queries[0]);

$stmt->fetch();

$conn->insert('user',
              array('name'   => 'Xuplau',
                    'email'  => 'xuplau@gmail.com',
                    'pwd'    => 'eecfd9748e36ffc4d37942064e14f822b0a7a1eb34f266a312d2152a8ac512de',
                    'uuid'   => '092227be-8d61-49c1-9bea-04f977af0f01',
                    'status' => 1));

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
--CLEAN--
<?php
$conn = null;
?>