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

use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
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
class Check
{

    protected $settings;
    protected $token;
    protected $userHash;
    protected $renew;
    protected $id;

    /**
     *
     * @param Array  $settings Auth settings
     * @param String $token Json Web Token
     *
     */
    public function __construct(Array $settings, $token)
    {
        $this->settings = $settings;

        $parser = new Parser;

        $this->token    = $parser->parse($token);
        $this->userHash = $this->token->getClaim('hash');
        $this->renew    = $this->token->getClaim('renew_token');
        $this->id       = $this->createId();
    }

    /**
     * Verify token
     *
     * @return Boolean Verify result
     */
    public function verify()
    {
        $signer  = new Sha256;

        return $this->token->verify($signer, $this->settings['key']);
    }

    /**
     * Validate token
     *
     * @return Boolean Validate result
     */
    public function validate()
    {
        $data = new ValidationData;
        $data->setIssuer($this->settings['issuer']);
        $data->setAudience($this->settings['audience']);
        $data->setId($this->id);

        return $this->token->validate($data);
    }

    /**
     * Create token id
     *
     * @return String sha256 hash
     */
    private function createId()
    {
        return hash('sha256',$this->settings['key'].$this->userHash.$this->renew);
    }
}
