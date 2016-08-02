--TEST--
Test insert blacklist
--CREDITS--
Ivan Rosolen <ivanrosolen [at] gmail [dot] com>
--FILE--
<?php
require_once 'vendor/autoload.php';

use Xuplau\Database\Blacklist;

$config = new \Doctrine\DBAL\Configuration();
$dsn    = ['url' => 'sqlite:///:memory:'];
$conn   = \Doctrine\DBAL\DriverManager::getConnection($dsn, $config);

$schema = new \Doctrine\DBAL\Schema\Schema();
$blacklistTable = $schema->createTable('blacklist');
$blacklistTable->addColumn('id',       'integer');
$blacklistTable->addColumn('token_id', 'string');
$blacklistTable->addColumn('type',     'string');
$blacklistTable->addColumn('created',  'string');
$blacklistTable->setPrimaryKey(['id']);

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

$token_id = 'hash';

$blacklist = new Blacklist($conn);
$result = $blacklist->save('hash', 'logout');

var_dump($result);

$result = $blacklist->save('hash_block', 'block');

var_dump($result);
?>
--EXPECT--
bool(true)
bool(true)

