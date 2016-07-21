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

namespace Xuplau\Handler;

use Silex\Application;
use Exception;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Xuplau\Exception\UserFriendlyException;

class ErrorHandler
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function __invoke(Exception $exception, $statusCode)
    {
        $body = [];

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $body['message'] = $exception->getMessage();
        }

        if ($exception instanceof ExceptionInterface) {
            $statusCode = 400;

            $body['message'] = $exception->getMainMessage();
            $input = $exception->getParam('input');
            if (!is_array($input)) {
                $body['wrong_value'] = $input;
            } else {
                $body['wrong_value'] = [];
                foreach ($input as $key => $value) {
                    if (is_object($value)) {
                        continue;
                    }
                    $body['wrong_value'][$key] = $value;
                }
            }

            if ($exception instanceof NestedValidationExceptionInterface) {
                $body['messages'] = $exception->getMessages();
            }
        }

        if ($exception instanceof UserFriendlyException) {
            $statusCode = 400;
            $body['message'] = vsprintf(
                $this->application->trans($exception->getMessageFormat()),
                $exception->getMessageParams()
            );
        }

        if ($this->application['debug'] == true) {
            $body['exception'] = [
                'message' => $exception->getMessage(),
                'class' => get_class($exception),
                'code' => $exception->getCode(),
                'file' => sprintf('%s:%d', $exception->getFile(), $exception->getLine()),
                'trace' => explode(PHP_EOL, $exception->getTraceAsString()),
            ];
        }

        return $this->application->json($body, $statusCode);
    }
}
