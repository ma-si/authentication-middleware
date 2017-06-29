<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Middleware;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = $config['authentication-middleware'];

        return new AuthenticationMiddleware(
            $container->get(AuthenticationService::class),
            $config['identity_key'],
            $config['whitelist'],
            $config['default_redirect_route']
        );
    }
}
