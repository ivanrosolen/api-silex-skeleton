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
     * Register all validators
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function register(Container $container)
    {
        $container['user_create.validator'] = function() use ($container) {
            return new UserCreateInput;
        };
        $container['user_update.validator'] = function() use ($container) {
            return new UserUpdateInput;
        };
        $container['user_delete.validator'] = function() use ($container) {
            return new UserDeleteInput;
        };
        $container['login.validator'] = function() use ($container) {
            return new LoginInput;
        };
        $container['renew_token.validator'] = function() use ($container) {
            return new AuthRenewInput;
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
