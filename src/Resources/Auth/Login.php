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

namespace Xuplau\Resources\Auth;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Xuplau\Resources\Auth\Create as AuthCreate;

/**
 * Resource that list users
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Auth
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Login
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     */
    public function __invoke(Application $application, Request $request)
    {

        $postData = $request->request->all();

        $application['login.validator']->assert($postData);

        $user = $application['user']->login($postData);

        if (!$user)
            return $application->json('Login inválido', 400);

        $auth  = new AuthCreate($application['auth'],$user['hash']);
        $token = $auth->create();

        return $application->json(['jwt'         => $token['jwt'],
                                   'renew_token' => $token['renew_token'],
                                   'name'        => $user['name'],
                                   'email'       => $user['email'],
                                   'hash'        => $user['hash']]);
    }
}
