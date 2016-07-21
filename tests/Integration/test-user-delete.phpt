--TEST--
Test delete user
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
$userTable->addColumn('uuid',    'string');
$userTable->addColumn('status',  'integer');

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

$uuid = 'uuid';
$userData = [
    'uuid'   => $uuid,
    'status' => 1,
];
$conn->insert('user', $userData);

$user = new User($conn);
$user = $user->delete(['uuid'=>'uuid']);

var_dump($user);
?>
--EXPECT--
bool(true)
