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
use Xuplau\Validation\Rules\UserCreateInput;
use Xuplau\Validation\Rules\UserUpdateInput;
use Xuplau\Validation\Rules\UserDeleteInput;
use Xuplau\Validation\Rules\LoginInput;
use Xuplau\Validation\Rules\AuthRenewInput;

/**
 * Serivice to provide all validators for the application
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 *
 */
class ValidationServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all routes
     *
     * @param Application $application Application instance
     * @return Void
     */
    public function register(Application $application)
    {
        $application['user_create.validator'] = function() use ($application) {
            return new UserCreateInput;
        };
        $application['user_update.validator'] = function() use ($application) {
            return new UserUpdateInput;
        };
        $application['user_delete.validator'] = function() use ($application) {
            return new UserDeleteInput;
        };
        $application['login.validator'] = function() use ($application) {
            return new LoginInput;
        };
        $application['renew_token.validator'] = function() use ($application) {
            return new AuthRenewInput;
        };
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
