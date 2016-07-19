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

namespace Xuplau\Validation\Rules;

use Respect\Validation\Rules;

/**
 * @version 1.0.0
 *
 * @package Xuplau\Validation\Rules
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class LoginInput extends Rules\AllOf
{
    public function __construct()
    {
        return $this->addRules([

            new Rules\Key('email', new Rules\Email(), true),

            // md5 hash
            new Rules\Key('pwd', new Rules\Length(32,32), true)
        ]);
    }
}
