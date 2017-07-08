<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware;

/**
 * The configuration provider for the Auth module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
//                'authentication.adapter' => Adapter\DummySuccessAdapter::class,
            ],
            'factories' => [
                Middleware\AuthenticationMiddleware::class => Middleware\AuthenticationMiddlewareFactory::class,
                Action\LoginAction::class => Action\LoginActionFactory::class,
                Action\LogoutAction::class => Action\LogoutActionFactory::class,
                \Zend\Authentication\AuthenticationService::class => Service\AuthenticationServiceFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
//            'paths' => [
//                'auth'    => [__DIR__ . '/../templates/auth'],
//
//                'app'    => [__DIR__ . '/../templates/app'],
//                'error'  => [__DIR__ . '/../templates/error'],
//                'layout' => [__DIR__ . '/../templates/layout'],
//            ],
        ];
    }
}
