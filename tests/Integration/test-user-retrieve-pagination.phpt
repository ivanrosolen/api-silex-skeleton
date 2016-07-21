--TEST--
Test retrieve users with pagination
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
$userTable->addColumn('name',   'string');
$userTable->addColumn('email',  'string');
$userTable->addColumn('uuid',   'string');
$userTable->addColumn('status', 'integer');

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

for ($i=1;$i<=6;$i++) {
    $userData = [
        'name'   => 'name'.$i,
        'email'  => 'email'.$i,
        'uuid'   => 'hash'.$i,
        'status' => 1
    ];
    $conn->insert('user', $userData);
}

$user = new User($conn);

var_dump($user->fetchPage(5,0));
var_dump($user->fetchPage(5,5));
?>
--EXPECT--
array(5) {
  [0]=>
  array(3) {
    ["hash"]=>
    string(5) "hash1"
    ["name"]=>
    string(5) "name1"
    ["email"]=>
    string(6) "email1"
  }
  [1]=>
  array(3) {
    ["hash"]=>
    string(5) "hash2"
    ["name"]=>
    string(5) "name2"
    ["email"]=>
    string(6) "email2"
  }
  [2]=>
  array(3) {
    ["hash"]=>
    string(5) "hash3"
    ["name"]=>
    string(5) "name3"
    ["email"]=>
    string(6) "email3"
  }
  [3]=>
  array(3) {
    ["hash"]=>
    string(5) "hash4"
    ["name"]=>
    string(5) "name4"
    ["email"]=>
    string(6) "email4"
  }
  [4]=>
  array(3) {
    ["hash"]=>
    string(5) "hash5"
    ["name"]=>
    string(5) "name5"
    ["email"]=>
    string(6) "email5"
  }
}
array(1) {
  [0]=>
  array(3) {
    ["hash"]=>
    string(5) "hash6"
    ["name"]=>
    string(5) "name6"
    ["email"]=>
    string(6) "email6"
  }
}
