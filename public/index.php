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

use Xuplau\Provider\DoctrineServiceProvider;
use Xuplau\Provider\RouteServiceProvider;
use Xuplau\Provider\DatabaseServiceProvider;
use Xuplau\Provider\ContentNegotiationServiceProvider;
use Xuplau\Provider\ValidationServiceProvider;
use Xuplau\Provider\LocaleServiceProvider;
use Xuplau\Provider\TranslationServiceProvider;

$application = require_once realpath(__DIR__.'/../bootstrap.php');

$application->register(new DoctrineServiceProvider);
$application->register(new RouteServiceProvider);
$application->register(new DatabaseServiceProvider);
$application->register(new ContentNegotiationServiceProvider);
$application->register(new ValidationServiceProvider);
$application->register(new LocaleServiceProvider);
$application->register(new TranslationServiceProvider);

$application->run();