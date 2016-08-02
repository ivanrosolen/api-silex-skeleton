--TEST--
Test user login
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
$userTable->addColumn('name',    'string');
$userTable->addColumn('email',   'string');
$userTable->addColumn('pwd',     'string');
$userTable->addColumn('uuid',    'string');
$userTable->addColumn('status',  'integer');

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

$userData = [
    'name'   => 'name',
    'email'  => 'test@gmail.com',
    'pwd'    => '52bbea75ee75a6f1d24781d56e6c8ffb9b76e1024013b516bbaaac27e21ae9e0',
    'uuid'   => 'hash',
    'status' => 1
];
$conn->insert('user', $userData);

$postData = [
    'email' => 'test@gmail.com',
    'pwd'   => '098f6bcd4621d373cade4e832627b4f6', // md5 test
];

$user = new User($conn);
$user = $user->login($postData);

var_dump($user);
?>
--EXPECT--
array(3) {
  ["name"]=>
  string(4) "name"
  ["email"]=>
  string(14) "test@gmail.com"
  ["hash"]=>
  string(4) "hash"
}
