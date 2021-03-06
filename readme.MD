# Бандл поддержки Middleware для Symfony

Форк [пакета](https://github.com/zholus/symfony-middleware-bundle). Доработано под личные нужды, добавлены
некоторые стандартные middleware.

## Инсталляция

`composer require proklung/symfony-middleware-bundle`

## Кастомные middlewares

1) **OnlyAjaxMiddleware** - проверка на Ajax вызов.
2) **CsrfMiddleware** - проверка Csrf токена.

## Оригинальная документация

This bundle allow you to create simple middleware that executes right before controller does on each requests.

Its almost looks like middleware in laravel framework.

There are 4 possible ways to inject your middleware to your request.

## Register middleware

### Global middleware

Global middleware executes on every http requests before every controller.

To register middleware as global you need implement interface `\Zholus\SymfonyMiddleware\GlobalMiddlewareInterface`. 

That's all.

### Controller middleware

This middleware will execute on every action in certain controller, to attach middleware to controller, you need setup some configuration in your services.yaml file:

    App\Controller\WelcomeController:
        tags:
            - { name: 'middleware.controller', middleware: 'App\Middleware\AuthNeededMiddleware' }

That's all, just attach tag with options: `name` - `middleware.controller` and `middleware` - fully-qualified class name.

You can attach more that one middleware to controller

    App\Controller\WelcomeController:
        tags:
            - { name: 'middleware.controller', middleware: 'App\Middleware\AuthNeededMiddleware' }
            - { name: 'middleware.controller', middleware: 'App\Middleware\AdminAccessMiddleware' }

### Action middleware

This middleware is similar to controller, we need to add just one more option called `action`

    App\Controller\WelcomeController:
        tags:
            - { name: 'middleware.controller', middleware: 'App\Middleware\AuthNeededMiddleware', action: 'index' }

That means that when action `index` will run, than our middleware will executed
 
 ### Route middleware

In your routes configuration file add array option called `middleware`:
    
    index:
        path: /
        controller: App\Controller\WelcomeController::index
        options:
            middleware: ['App\Middleware\AuthNeededMiddleware', 'App\Middleware\AdminAccessMiddleware']

Those middlewares will attach to route name in our example to `index`.

## Priority of middleware executions

Order of execution of different types of middleware is next: `global` middleware execute first, next `controller`, next `action` and last `route`.

For global middlewares you can specify in services.yaml, lets see an example

    App\Middleware\AuthNeededMiddleware:
        tags:
            - { name: 'middleware.global', priority: 2 }
            
    App\Middleware\AdminAccessMiddleware:
        tags:
            - { name: 'middleware.global', priority: 1 }

Default priority without specifying in configuration is 0. The higher the number, the earlier a middleware is executed.

For other 3 types (controller, action, route) priority will the same is in the configuration, for example in route configuration: 

    index:
        path: /
        controller: App\Controller\WelcomeController::index
        options:
            middleware: ['App\Middleware\AuthNeededMiddleware', 'App\Middleware\AdminAccessMiddleware']

First will execute `App\Middleware\AuthNeededMiddleware` and next `App\Middleware\AdminAccessMiddleware`. And same in other 2 types.

## Middleware example

In example below, our middleware check if given credentials is represent user with admin access, if not, we will return response with access denied message.

As we can see, if any of middlewares returning Response, it means that next middlewares will not be executed.

Returning of null means that next middleware will be executed.


```php
<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zholus\SymfonyMiddleware\MiddlewareInterface;
use App\Repository\UserRepository;

final class AdminAccessMiddleware implements MiddlewareInterface
{
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function handle(Request $request): ?Response
    {
        $login = $request->get('login');
        $password = $request->get('password');
        
        $user = $this->userRepository->findByCredentials($login, $password);
        
        if ($user === null || !$user->isAdmin()) {
            return new Response('Denied access', 403);
        }
        
        return null;
    }
}

```
