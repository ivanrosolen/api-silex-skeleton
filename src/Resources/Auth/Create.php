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

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Ramsey\Uuid\Uuid;

/**
 * Resource that will create a jwt
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Auth
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Create
{

    protected $settings;
    protected $userHash;
    protected $renew;

    /**
     *
     * @param Array $settings Auth settings
     * @param String $userHash User hash
     *
     */
    public function __construct(Array $settings, $userHash)
    {
        $this->settings = $settings;
        $this->userHash = $userHash;
    }

    /**
     * Create token
     *
     * @return Array Json Web Token and Renew Token
     */
    public function create()
    {
        $signer  = new Sha256;
        $builder = new Builder;

        $this->renew = md5((string) Uuid::uuid4());
        $id = $this->createId();

        $token = $builder->setIssuer($this->settings['issuer'])
                         ->setAudience($this->settings['audience'])
                         ->setId($id, true)
                         ->setIssuedAt(time())
                         ->setNotBefore(time() - 1)
                         ->setExpiration(time() + $this->settings['expiration'])
                         ->set('renew_token', $this->renew)
                         ->set('hash', $this->userHash)
                         ->sign($signer, $this->settings['key'])
                         ->getToken();

        return ['jwt' => (string) $token, 'renew_token' => $this->renew ];
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
