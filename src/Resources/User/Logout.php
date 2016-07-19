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
use Lcobucci\JWT\Parser;

/**
 * Resource that list users
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\User
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Logout
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     * @param String $id Id of product
     * @return Array Json with product
     */
    public function __invoke(Application $application, Request $request)
    {

        $uri = $request->getRequestUri();

        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token)
            return $application->json('Expectation Failed',417);

        $parser = new Parser;

        $jwt = $parser->parse($token);
        $this->id = $jwt->getHeader('jti');

        $blacklist = $application['blacklist']->save($this->id,'logout');

        if (!$blacklist)
            return $application->json('', 404);

        return $application->json('', 200);
    }
}
