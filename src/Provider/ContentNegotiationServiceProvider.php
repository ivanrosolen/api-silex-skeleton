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
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ContentNegotiationServiceProvider implements ServiceProviderInterface
{
    public function register(Application $application)
    {
        $application->error(new ErrorHandler($application));
    }

    public function boot(Application $application)
    {
        // Nothing here
    }
}
