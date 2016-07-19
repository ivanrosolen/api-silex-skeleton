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

namespace Xuplau\Resources\Auth;

use Lcobucci\JWT\Parser;
use Ramsey\Uuid\Uuid;
use Silex\Application;

/**
 * Resource that will create a jwt
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Auth
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Blacklist
{

    protected $settings;
    protected $token;
    protected $id;
    protected $application;

    /**
     *
     * @param Application $application Application instance
     * @param String      $token Json Web Token
     */
    public function __construct(Application $application, $token)
    {
        $this->application = $application;

        $parser = new Parser;

        $this->token = $parser->parse($token);
        $this->id    = $this->token->getHeader('jti');
    }

    public function save()
    {
        $blacklist = $this->application['blacklist']->save($this->id,'block');

        if (!$blacklist)
            return $this->application->json('', 404);

    }

    public function check()
    {

        $blacklist = $this->application['blacklist']->fetch($this->id);

        if (!$blacklist)
            return false;

        return true;
    }

}
