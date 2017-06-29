<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Action;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class LogoutActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LogoutAction(
            $container->get(AuthenticationService::class)
        );
    }
}
