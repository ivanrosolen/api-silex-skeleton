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
use Xuplau\Database\Sql\FindByKeySql;

class Blacklist
{
    private $connection;
    private $tableName;

    public function __construct(Connection $connection, $tableName)
    {
        $this->connection = $connection;
        $this->tableName  = $tableName;
    }

    public function fetch($token_id)
    {

        $user = new FindByKeySql($this->connection,
                                 $this->tableName,
                                 array('token_id'),
                                 'token_id',
                                 $token_id);
        $token = $user->execute();

        if (count($token) == 0)
            return false;

        return $token[0];
    }

    public function save($token_id)
    {

        $data['token_id'] = $token_id;
        $data['created']  = date('Y-m-d H:i:s');

        $names = ['token_id' =>':token_id',
                  'created'  =>':created'];

        $queryBuilder = $this->connection->createQueryBuilder();
        $query        = $queryBuilder->insert($this->tableName)
                                     ->values($names);

        foreach ($data as $key => $value) {
            $query->setParameter(':'.$key,$value);
        }

        $query->execute();

    }

}
