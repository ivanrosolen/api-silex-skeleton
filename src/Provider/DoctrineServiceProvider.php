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
use Silex\Provider\DoctrineServiceProvider as DoctrineProvider;

/**
 * Provides doctrine DBAL
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 *
 */
class DoctrineServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all routes
     *
     * @param Application $application Application instance
     * @return Void
     */
    public function register(Application $application)
    {
        $application->register(new DoctrineProvider(),[
            'dbs.options' => [
                'apidb' => $application['apidb']
            ]
        ]);
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
