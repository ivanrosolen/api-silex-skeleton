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

namespace Xuplau\Exception;

class UserFriendlyException extends \Exception
{
    protected $messageFormat;
    protected $messageParams = [];

    public function __construct($messageFormat, array $messageParams = [], \Exception $previous = null, $code = 0)
    {
        $this->messageFormat = $messageFormat;
        $this->messageParams = $messageParams;

        $message = vsprintf($messageFormat, $messageParams);

        parent::__construct($message, $code, $previous);
    }

    public function getMessageFormat()
    {
        return $this->messageFormat;
    }

    public function getMessageParams()
    {
        return $this->messageParams;
    }
}
