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

namespace Xuplau\Resources\User;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resource that create one user
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\User
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 */
class Create
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request     $request Request instance
     * @return Array Json
     */
    public function __invoke(Application $application, Request $request)
    {

        $postData = $request->request->all();

        $application['user_create.validator']->assert($postData);

        $user = $application['user']->create($postData);

        if (!$user)
            return $application->json('', 404);

        // colocar rmm4 links

        // send email
        $transport = \Swift_SmtpTransport::newInstance(
            $application['swiftmailer']['host'],
            $application['swiftmailer']['port']);

        //$transport->setUsername($application['swiftmailer']['user']);
        //$transport->setPassword($application['swiftmailer']['pwd']);

        $mailer  = \Swift_Mailer::newInstance($transport);


        $message = \Swift_Message::newInstance()
            ->setSubject('New User')
            ->setFrom(array($application['swiftmailer']['from']))
            ->setTo(array('ivanrosolen@gmail.com'))
            ->setBody(serialize($user))
            ->setContentType('text/html');

        $send = $mailer->send($message);

        return $application->json($user,201);

    }
}
