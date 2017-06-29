<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouteResult;

class AuthenticationMiddleware implements ServerMiddlewareInterface
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var string
     */
    private $identityKey;

    /**
     * @var array
     */
    private $whitelist;

    /**
     * @var string|null
     */
    private $redirectRoute;

    /**
     * AuthenticationMiddleware constructor.
     *
     * @param AuthenticationService $authenticationService
     * @param string $identityKey
     * @param array $whitelist Routes whitelisted for unauthenticated
     * @param string|null $redirectRoute
     */
    public function __construct(
        AuthenticationService $authenticationService,
        $identityKey = 'identity',
        $whitelist = ['login', 'logout'],
        $redirectRoute = null
    ) {
        $this->authenticationService = $authenticationService;
        $this->identityKey = $identityKey;
        $this->whitelist = $whitelist;
        $this->redirectRoute = $redirectRoute;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return \Psr\Http\Message\ResponseInterface|RedirectResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $route = $request->getAttribute(RouteResult::class);

        /** no route matched - process to 404 */
        if (! $route) {
            return $delegate->process($request);
        }
        $routeName = $route->getMatchedRoute()->getName();

        /**
         * If redirection set in config
         * Redirect unauthenticated
         * Keeping whitelisted routes accessible for unauthenticated
         */
        if (! $this->authenticationService->hasIdentity()
            && ! in_array($routeName, $this->whitelist)
            && null !== $this->redirectRoute
        ) {
            return new RedirectResponse($this->redirectRoute);
        }

        $identity = $this->authenticationService->getIdentity();

        return $delegate->process($request->withAttribute($this->identityKey, $identity));
    }
}
