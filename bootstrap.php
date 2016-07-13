<?php
/**
 * This file is part of reatil pip api application.
 *
 * @copyright 2015 Arizona Tecnologia - All Rights Reserved
 * @link      https://github.com/Arizona-Tecnologia/dragndroptool
 */

include_once __DIR__.'/vendor/autoload.php';

use ArizonaTecnologia\RetailPIP\Application;

return call_user_func(function () {
    $settings = include __DIR__ . '/config/settings.php';

    foreach ($settings['php'] as $key => $value) {
        ini_set($key, $value);
    }

    $settings['debug'] = (bool) $settings['debug'];
    $settings['pretty'] = array_key_exists('pretty', $_GET);

    unset($_GET['pretty']);

    $application = new Application($settings);

    return $application;
});
