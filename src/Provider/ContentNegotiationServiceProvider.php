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

use Xuplau\Handler\ErrorHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ContentNegotiationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->error(new ErrorHandler($container));
    }

    public function boot(Container $container)
    {
        // Nothing here
    }
}
