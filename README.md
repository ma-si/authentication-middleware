# Authentication Middleware [![SensioLabsInsight](https://insight.sensiolabs.com/projects/c344bb5d-9d66-4f63-b006-b4d758643904/small.png)](https://insight.sensiolabs.com/projects/c344bb5d-9d66-4f63-b006-b4d758643904)

[![Build status][Master image]][Master]
[![Coverage Status][Master coverage image]][Master coverage]
[![Code Climate][Code Climate image]][Code Climate]
[![Sensio][SensioLabsInsight image]][SensioLabsInsight]
[![Packagist][Packagist image]][Packagist]

[![inimum PHP Version][Minimum PHP Version image]][PHP]
[![License][License image]][License]

*PSR-7 Authentication Middleware.*

## Installation

Install via composer:

```console
$ composer require aist/authentication-middleware
```

## Configuration

### Add configuration file
copy authentication-middleware.global.php.dist to authentication-middleware.global.php
```php
// authentication-middleware.global.php.dist
return [
    'authentication-middleware' => [
        'identity_key' => 'identity',
        'default_redirect_route' => 'login',
        'success_redirect_route' => 'home',
        'success_role_redirect_route' => [
            'admin' => 'admin/dashboard',
            'user' => 'home',
        ],
        'whitelist' => [
            'login',
            'logout',
        ],
    ],
];
```

### Register your own authentication adapter
by invokables
```php
'invokables' => [
    'authentication.adapter' => \App\Authentication\Adapter\YourAdapter::class,
],
```
or by factories
```php
'factories' => [
    'authentication.adapter' => \App\Authentication\Adapter\YourAdapterFactory::class,
],
```

### Register your own login action
```php
'factories'  => [
    \Aist\AuthenticationMiddleware\Action\LoginAction::class => LoginFactory::class,
],
```

### Register your own login form
```php
'form_elements' => [
    'factories'  => [
        'Aist\AuthenticationMiddleware\Form\LoginForm' => \App\Form\LoginCompanyFormFactory::class,
    ],
],
```

### Add pipe

to protect whole app
```php
// Add more middleware here that needs to introspect the routing results; this
// might include:
//
// - route-based authentication
// - route-based validation
// - etc.

// Authentication middleware
$app->pipe(\Aist\AuthenticationMiddleware\Middleware\AuthenticationMiddleware::class);

// Permission middleware
// At this point, if no identity is set by authentication middleware, the
// UnauthorizedHandler kicks in; alternately, you can provide other fallback
// middleware to execute.
//$app->pipe(\Aist\AuthorizationMiddleware\Middleware\UnauthorizedHandler::class);
// Authorization
$app->pipe(\Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddleware::class);
```
or use for specific route
```php
$app->get(
    '/',
    [
        \Aist\AuthenticationMiddleware\Middleware\AuthenticationMiddleware::class,
        \Aist\AuthorizationMiddleware\Middleware\AuthorizationMiddleware::class,
        App\Action\DashboardAction::class,
    ],
    'dashboard'
);
```

### Add authentication routes
```php
$app->route('/login', \Aist\AuthenticationMiddleware\Action\LoginAction::class, ['GET', 'POST'], 'login');
$app->get('/logout', Aist\AuthenticationMiddleware\Action\LogoutAction::class, 'logout');
```

  [Master image]: https://img.shields.io/travis/ma-si/authentication-middleware/master.svg?style=flat-square&label=master
  [Master]: https://secure.travis-ci.org/ma-si/authentication-middleware
  [Master coverage image]: https://img.shields.io/coveralls/ma-si/authentication-middleware/master.svg?style=flat-square&label=master&nbsp;coverage
  [Master coverage]: https://coveralls.io/r/ma-si/authentication-middleware?branch=master
  
  [Code Climate image]: https://img.shields.io/codeclimate/github/ma-si/authentication-middleware.svg?style=flat-square
  [Code Climate]: https://codeclimate.com/github/ma-si/authentication-middleware
  
  [SensioLabsInsight image]: https://img.shields.io/sensiolabs/i/c344bb5d-9d66-4f63-b006-b4d758643904.svg?style=flat-square
  [SensioLabsInsight]: https://insight.sensiolabs.com/projects/c344bb5d-9d66-4f63-b006-b4d758643904
  
  [Packagist image]: https://img.shields.io/packagist/v/aist/authentication-middleware.svg?style=flat-square
  [Packagist]: https://packagist.org/packages/aist/authentication-middleware
  
  [Minimum PHP Version image]: https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square
  [PHP]: https://php.net
  [License image]: https://poser.pugx.org/aist/authentication-middleware/license?format=flat-square
  [License]: https://opensource.org/licenses/BSD-3-Clause
