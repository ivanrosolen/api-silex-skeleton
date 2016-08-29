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
namespace Xuplau\Resources;

use Silex\Application;

/**
 * Index Route. Show info about this application
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Index
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @return Array Json
     */
    public function __invoke(Application $application)
    {

        return $application->json([
            'description' => $application['translator']->trans('index'),
            'version'     => $application['version']
        ]);
    }
}
