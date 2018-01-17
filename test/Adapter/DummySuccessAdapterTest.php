<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace AistTest\AuthenticationMiddleware\Adapter;

use Aist\AuthenticationMiddleware\Adapter\DummySuccessAdapter;
use PHPUnit\Framework\TestCase;
use Zend\Authentication\Adapter\AbstractAdapter;

/**
 * {@inheritDoc}
 */
class DummySuccessAdapterTest extends TestCase
{
    public function testFactoryWithTemplate()
    {
        $adapter = new DummySuccessAdapter();

        $this->assertInstanceOf(AbstractAdapter::class, $adapter);
    }
}
