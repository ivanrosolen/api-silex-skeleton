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
class UserUpdateInput extends Rules\AllOf
{
    public function __construct()
    {
        return $this->addRules([

            new Rules\Key('name', new Rules\Length(2, 50, true), true),

            new Rules\Key('email', new Rules\Email(), true),

            new Rules\Key('pwd', new Rules\NoWhitespace(), false),
            new Rules\Key('pwd', new Rules\Length(5,null, true), false),

            new Rules\Key('uuid', new Rules\NoWhitespace(), true),
            new Rules\Key('uuid', new Rules\Length(10, null, true), true)
        ]);
    }
}
