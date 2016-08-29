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

namespace Xuplau\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Xuplau\Resources\Auth\RequestValidator as AuthRequestValidator;
use Xuplau\Resources\Auth\Login            as AuthLogin;
use Xuplau\Resources\Auth\Logout           as AuthLogout;
use Xuplau\Resources\Auth\Renew            as AuthRenew;
use Xuplau\Resources\Index;
use Xuplau\Resources\User\Create   as UserCreate;
use Xuplau\Resources\User\Retrieve as UserRetrieve;
use Xuplau\Resources\User\Update   as UserUpdate;
use Xuplau\Resources\User\Delete   as UserDelete;

/**
 * Serivice to provide all routes for the application
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 *
 */
class RouteServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all routes
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function register(Container $container)
    {
        $container->get('/', new Index);

        $container->post('/user',          new UserCreate);
        $container->put('/user/{hash}',    new UserUpdate);
        $container->delete('/user/{hash}', new UserDelete);
        $container->get('/users',          new UserRetrieve);
        $container->get('/users/{page}',   new UserRetrieve); // pagination

        $container->post('/auth/login', new AuthLogin);
        $container->get('/auth/logout', new AuthLogout);
        $container->post('/auth/renew', new AuthRenew);

        $container->before(new AuthRequestValidator);
    }

    /**
     * Boot
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function boot(Container $container)
    {
        // Nothing here
    }
}
