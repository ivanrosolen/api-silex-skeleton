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
use Xuplau\Database\User;
use Xuplau\Database\Blacklist;

/**
 * Provides database objects
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 *
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all objects
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function register(Container $container)
    {
        $container['user'] = function() use ($container) {
            return new User($container['dbs']['apidb'],'user');
        };
        $container['blacklist'] = function() use ($container) {
            return new Blacklist($container['dbs']['apidb'],'blacklist');
        };
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
