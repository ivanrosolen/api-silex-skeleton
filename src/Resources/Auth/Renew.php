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
use Xuplau\Resources\Auth\Check  as AuthCheck;
use Lcobucci\JWT\Parser;

/**
 * Resource that renew a token
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Auth
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Renew
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     */
    public function __invoke(Application $application, Request $request)
    {

        $uri = $request->getRequestUri();

        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token)
            return $application->json('Expectation Failed',417);

        $check = new AuthCheck($application['auth'], $token);

        if (!$check->verify())
            return $application->json('Forbidden',403);

        $postData = $request->request->all();
        $application['renew_token.validator']->assert($postData);

        $parser = new Parser;
        $jwt    = $parser->parse($token);
        $renew  = $jwt->getClaim('renew_token');
        $hash   = $jwt->getClaim('hash');

        if ($renew != $postData['renew_token'])
            return $application->json('Forbidden',403);

        $auth  = new AuthCreate($application['auth'],$hash);
        $token = $auth->create();

        return $application->json($token,201);

    }
}
