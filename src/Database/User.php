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
use Ramsey\Uuid\Uuid;
use Xuplau\Database\Sql\FindByKeySql;

class User
{

    const ACTIVE    = 1;
    const INACTIVE  = 2;
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
                    ->select('uuid as hash,name,email')
                    ->from($this->tableName)
                    ->where('status = :status')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter(':status', self::ACTIVE)
                    ->execute()
                    ->fetchAll();

        return $result;
    }

    public function create(Array $postData)
    {

        // encrypt password
        $postData['pwd'] = hash('sha256',$postData['pwd']);

        $postData['uuid']    = (string) Uuid::uuid4();
        $postData['status']  = '1';
        $postData['created'] = date('Y-m-d H:i:s');

        $names = ['name'    =>':name',
                  'email'   =>':email',
                  'pwd'     =>':pwd',
                  'uuid'    =>':uuid',
                  'status'  =>':status',
                  'created' =>':created'];

        $queryBuilder = $this->connection->createQueryBuilder();
        $query        = $queryBuilder->insert($this->tableName)
                                     ->values($names);

        foreach ($postData as $key => $value) {
            $query->setParameter(':'.$key,$value);
        }

        $query->execute();

        $id = $this->connection->lastInsertId();

        $user = new FindByKeySql($this->connection,
                                 $this->tableName,
                                 array('uuid as hash','name','email'),
                                 'id',
                                 $id);

        return $user->execute()[0];
    }

    public function login(Array $postData)
    {

        // encrypt password
        $postData['pwd'] = hash('sha256',$postData['pwd']);
        $postData['status']  = '1';

        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder
                    ->select('name,email,uuid as hash')
                    ->from($this->tableName)
                    ->where(
                        $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('email', ':email'),
                        $queryBuilder->expr()->eq('pwd', ':pwd'),
                        $queryBuilder->expr()->eq('status', ':status')
                    ))
                    ->setParameter(':email',  $postData['email'])
                    ->setParameter(':pwd',    $postData['pwd'])
                    ->setParameter(':status', $postData['status'])
                    ->execute()
                    ->fetch();

        return $result;
    }

}
