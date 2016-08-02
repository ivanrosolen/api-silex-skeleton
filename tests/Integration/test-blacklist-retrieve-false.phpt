--TEST--
Test retrieve false blacklist
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
$blacklistTable->addColumn('token_id', 'string');

$platform = $conn->getDatabasePlatform();
$queries  = $schema->toSql($platform);
$stmt     = $conn->query($queries[0]);
$stmt->fetch();

$blacklistData = [
    'token_id' => 'hash',
];
$conn->insert('blacklist', $blacklistData);

$token_id = 'hash_valid';

$blacklist = new Blacklist($conn);
$blacklist = $blacklist->fetch($token_id);

var_dump($blacklist);
?>
--EXPECT--
bool(false)
