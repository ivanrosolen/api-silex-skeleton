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
use Silex\Provider\TranslationServiceProvider as TranslationProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

/**
 * Serivice to provide all translations
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 *
 */
class TranslationServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all languages
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function register(Container $container)
    {

        $container->register(new TranslationProvider);

        $container['translator'] = $container->extend('translator', function ($translator, $container) {
            $translator->addLoader('yaml', new YamlFileLoader);

            foreach ($container['locales'] as $lang => $path) {
                $translator->addResource('yaml', $path, $lang);
            }

            return $translator;
        });

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
