<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

/**
 * Authentication DummyAdapter
 *
 * Provides dummy success authentication.
 * Should be overridden in config:
 * 'invokables' => [
 *     'authentication.adapter' => \App\Authentication\Adapter\YourAdapter::class,
 * ],
 *
 * It uses given identity and ads default role to it.
 */
class DummySuccessAdapter extends AbstractAdapter
{
    /**
     * Performs an authentication attempt
     *
     * @return Result
     */
    public function authenticate()
    {
        $identity = $this->identity;
        $identity['role'] = 'user';

        return new Result(Result::SUCCESS, $identity);
    }
}
