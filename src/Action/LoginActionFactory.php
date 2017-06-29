<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Action;

use Aist\AuthenticationMiddleware\Form\LoginForm;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get('authentication.adapter'),
            $container->get('FormElementManager')->get(LoginForm::class)
        );
    }
}
