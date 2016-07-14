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

use Silex\Application;
use Silex\ServiceProviderInterface;
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
     * @param Application $application Application instance
     * @return Void
     */
    public function register(Application $application)
    {
        $application->get('/', new Index());

        $application->post('/user',        new UserCreate);
        $application->put('/user/{id}',    new UserUpdate);
        $application->delete('/user/{id}', new UserDelete);
        $application->get('/users',        new UserRetrieve);
        $application->get('/users/{page}', new UserRetrieve); // pagination
    }

    /**
     * Boot
     *
     * @param Application $application Application instance
     * @return Void
     */
    public function boot(Application $application)
    {
        // Nothing here
    }
}
