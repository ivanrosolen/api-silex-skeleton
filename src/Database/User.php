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

class User
{

    const ACTIVE    = 1;
    const INACTIVE  = 2;
    const DELETED   = 3;

    protected $connection;
    protected $tableName;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->tableName  = 'user';
    }

    public function fetch($uuid)
    {

        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder
                    ->select('uuid as hash,name,email')
                    ->from($this->tableName)
                    ->where(
                        $queryBuilder->expr()->andX(
                        $queryBuilder->expr()->eq('status', ':status'),
                        $queryBuilder->expr()->eq('uuid', ':uuid')
                    ))
                    ->setParameter(':status', self::ACTIVE)
                    ->setParameter(':uuid', $uuid)
                    ->execute()
                    ->fetch();

        return $result;
    }

    public function fetchAll()
    {

        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder
                    ->select('uuid as hash,name,email')
                    ->from($this->tableName)
                    ->where('status = :status')
                    ->setParameter(':status', self::ACTIVE)
                    ->execute()
                    ->fetchAll();

        return $result;
    }

    public function fetchPage($limit, $offset)
    {

        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder
                    ->select('uuid as hash,name,email')
                    ->from($this->tableName)
                    ->where('status = :status')
                    ->setParameter(':status', self::ACTIVE)
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->execute()
                    ->fetchAll();

        return $result;
    }

    public function create(Array $postData)
    {

        // encrypt password
        $postData['pwd'] = hash('sha256',$postData['pwd']);

        $postData['uuid']    = (string) Uuid::uuid4();
        $postData['status']  = self::ACTIVE;
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

        $user = $this->fetch($postData['uuid']);

        return $user;
    }

    public function update(Array $putData)
    {

        $names = ['name'  =>':name',
                  'email' =>':email'];

        if ( isset($putData['pwd']) && !empty($putData['pwd'])) {
            // encrypt password
            $putData['pwd'] = hash('sha256',$putData['pwd']);
            $names['pwd']   = ':pwd';
        }

        $names['uuid'] = ':uuid';

        $queryBuilder = $this->connection->createQueryBuilder();
        $query        = $queryBuilder->update($this->tableName)
                                     ->where('uuid = :uuid');

        foreach ($names as $key => $value) {
            $query->set($key,$value);
        }
        foreach ($putData as $key => $value) {
            $query->setParameter(':'.$key,$value);
        }

        if (!$query->execute()) return false;

        $user = $this->fetch($putData['uuid']);

        return $user;

    }

    public function delete($data)
    {

        $data['status'] = self::DELETED;

        $names = ['uuid'   =>':uuid',
                  'status' =>':status'];

        $queryBuilder = $this->connection->createQueryBuilder();
        $query        = $queryBuilder->update($this->tableName)
                                     ->where('uuid = :uuid');

        foreach ($names as $key => $value) {
            $query->set($key,$value);
        }
        foreach ($data as $key => $value) {
            $query->setParameter(':'.$key,$value);
        }

        return (bool) $query->execute();
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
