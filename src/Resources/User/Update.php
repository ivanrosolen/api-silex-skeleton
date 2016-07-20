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
 * Resource that update one user
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\User
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Update
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     * @param String $hash User uuid
     * @return Array Json
     */
    public function __invoke(Application $application, Request $request, $hash)
    {
        $putData = $request->request->all();

        $putData['uuid'] = $hash;

        $application['user_update.validator']->assert($putData);

        $user = $application['user']->update($putData);

        if (!$user)
            return $application->json('', 404);

        // colocar rmm4 links

        return $application->json($user,200);
    }
}
