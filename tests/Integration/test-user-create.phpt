--TEST--
Test create user
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require_once 'vendor/autoload.php';

use Xuplau\Database\User;

$config = new \Doctrine\DBAL\Configuration();
$dsn    = ['url' => 'sqlite:///:memory:'];
$conn   = \Doctrine\DBAL\DriverManager::getConnection($dsn, $config);

$schema = new \Doctrine\DBAL\Schema\Schema();
$userTable = $schema->createTable('user');
$userTable->addColumn('id',      'integer');
$userTable->addColumn('name',    'string');
$userTable->addColumn('email',   'string');
$userTable->addColumn('pwd',     'string');
$userTable->addColumn('uuid',    'string');
$userTable->addColumn('status',  'integer');
$userTable->addColumn('created', 'string');
$userTable->setPrimaryKey(['id']);

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

$userData = [
    'name'  => 'name',
    'email' => 'email',
    'pwd'   => 'pwd',
];

$user = new User($conn);
$user = $user->create($userData);
$user['hash'] = 'hash';

var_dump($user);
?>
--EXPECT--
array(3) {
  ["hash"]=>
  string(4) "hash"
  ["name"]=>
  string(4) "name"
  ["email"]=>
  string(5) "email"
}
