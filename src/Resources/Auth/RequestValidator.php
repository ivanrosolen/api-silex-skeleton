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
use Xuplau\Resources\Auth\Check;

/**
 * Resource that validate if request need to have jwt
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Auth
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class RequestValidator
{
    /**
     * Invokes route
     *
     * @param Request $request Request instance
     * @param Application $application Application instance
     */
    public function __invoke(Request $request, Application $application)
    {

        $uri = $request->getRequestUri();

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) &&
            !is_null($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $locale = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            if (in_array($locale, array_keys($application['locales'])))
                $application['translator']->setLocale($locale);
        }

        preg_match('/^(\/auth.+|\/$)/', $uri, $matches);

        if(count($matches) > 0) return;

        if (is_null($request->headers->get('Authorization')))
            return $application->json('Expectation Failed',417);

        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token)
            return $application->json('Expectation Failed',417);

        $check     = new Check($application['auth'], $token);
        $blacklist = new Blacklist($application, $token);

        if (!$check->verify())
        {
            $blacklist->save();
            return $application->json('Forbidden',403);
        }

        if($blacklist->check())
            return $application->json('Forbidden',403);


        if (!$check->validate())
            return $application->json('Expired',412);

    }
}
