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

namespace Xuplau\Database\Sql;

use Doctrine\DBAL\Connection;

/**
 * Execute a select sql query where condition based on passed key name
 * and a key value
 *
 * @version 1.0.0
 *
 * @package Xuplau\Database\Sql
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class FindByKeySql
{
    /**
     * @var String table name
     */
    protected $tableName;

    /**
     * @var Array Columns that will be selected
     */
    protected $columns;

    /**
     * @var String $keyName the name of file for where condition
     */
    protected $keyName;

    /**
     * @var String $keyValue the value that will be uset on where condition
     */
    protected $keyValue;

    /**
     * Sql constructor
     *
     * @param Connection $connection Doctrine connection instance
     * @param String     $tableName  The table name
     * @param Array      Columns     Columns that will be selected
     * @param String     $keyName    The name of file for where condition
     * @param String     $keyValue   The value that will be uset on where condition
     */
    public function __construct(
        Connection $connection,
        $tableName,
        Array $columns,
        $keyName,
        $keyValue
    ) {
        $this->connection = $connection;
        $this->tableName  = $tableName;
        $this->columns    = $columns;
        $this->keyName    = $keyName;
        $this->keyValue   = $keyValue;
    }

    /**
     * Generate string sql query
     *
     * @return String sql querty
     */
    public function execute()
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
                    ->select(implode(', ', $this->columns))
                    ->from($this->tableName)
                    ->where($this->keyName . ' = ?')
                    ->setParameter(0, $this->keyValue)
                    ->execute()
                    ->fetchAll();
    }
}
