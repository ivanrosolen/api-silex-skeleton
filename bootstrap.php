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

use Xuplau\Application;

require_once realpath(__DIR__.'/vendor/autoload.php');

return call_user_func(function () {
    $settings = require_once realpath(__DIR__.'/config/settings.php');

    foreach ($settings['php'] as $key => $value) {
        ini_set($key, $value);
    }

    $settings['debug'] = (bool) $settings['debug'];

    $application = new Application($settings);

    return $application;
});