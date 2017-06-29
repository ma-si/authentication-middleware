<?php

/**
 * Aist Authentication Middleware (http://mateuszsitek.com/projects/authentication-middleware)
 *
 * @copyright Copyright (c) 2017 DIGITAL WOLVES LTD (http://digitalwolves.ltd) All rights reserved.
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Aist\AuthenticationMiddleware\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginAction implements ServerMiddlewareInterface
{
    private $auth;
    private $authAdapter;
    private $template;
    private $form;

    public function __construct(
        TemplateRendererInterface $template,
        AuthenticationService $auth,
        AdapterInterface $authAdapter,
        $form
    ) {
        $this->template = $template;
        $this->auth = $auth;
        $this->authAdapter = $authAdapter;
        $this->form = $form;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($request->getMethod() === 'POST') {
            return $this->authenticate($request);
        }

        return new HtmlResponse($this->template->render('auth::login', [
            'form' => $this->form,
        ]));
    }

    public function authenticate(ServerRequestInterface $request)
    {
        $flash = $request->getAttribute('flash');
        $params = $request->getParsedBody();

        if (empty($params['username'])) {
            $flash->addMessage('danger', 'The username cannot be empty');
            return new HtmlResponse($this->template->render('auth::login', [
                'error' => 'The username cannot be empty',
                'form' => $this->form,
            ]));
        }

        if (empty($params['password'])) {
            $flash->addMessage('danger', 'The password cannot be empty');
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The password cannot be empty',
                'form' => $this->form,
            ]));
        }

        $this->authAdapter->setIdentity(['username' => $params['username']]);
        $this->authAdapter->setCredential($params['password']);

        $result = $this->auth->authenticate();

        if (! $result->isValid()) {
            $flash->addMessage('danger', 'The credentials provided are not valid');
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The credentials provided are not valid',
                'form' => $this->form,
            ]));
        }

        $flash->addMessage('success', 'authentication success');

        return new RedirectResponse('/');
    }
}
