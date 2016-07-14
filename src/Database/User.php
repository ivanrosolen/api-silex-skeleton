<?php
/**
 * This file is part of api silex skeleton
 *
 * PHP version 7
 *
 * @category  PHP
 * @package   Xuplau
 * @author    Ivan Rosolen <ivanrosolen@gmail.com>
 * @author    William Espindola <oi@williamespindola.com.br>
 * @copyright 2016 Xuplau
 * @license   MIT
 * @link      https://github.com/ivanrosolen/api-silex-skeleton
 */

namespace Xuplau\Database;

use Doctrine\DBAL\Connection;

class User
{
    private $connection;
    private $tableName;

    public function __construct(Connection $connection, $tableName)
    {
        $this->connection = $connection;
        $this->tableName  = $tableName;
    }

    public function fetchAll($limit, $offset)
    {

        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder
                    ->select('*')
                    ->from($this->tableName)
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->execute()
                    ->fetchAll();

        return $result;
    }
}
