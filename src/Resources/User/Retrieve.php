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

namespace Xuplau\Resources\User;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resource that list users
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\User
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Retrieve
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     * @param String $id Id of product
     * @return Array Json with product
     */
    public function __invoke(
        Application $application,
        Request $request,
        $page = null
    ) {

        $page   = (!empty((int)$page)) ? $page : 1;
        $offset = ($page == 1) ? '0' : ($page*50)-50;
        $limit  = 10;

        $users = $application['user']->fetchAll($limit, $offset);

        if (!$users)
            return $application->json([], 404);

        // colocar rmm4 links

        return $application->json($users);
    }
}
