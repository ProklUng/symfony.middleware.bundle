<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

use Prokl\SymfonyMiddlewareBundle\GlobalMiddlewareInterface;
use Prokl\SymfonyMiddlewareBundle\MiddlewareInterface;

/**
 * Class MiddlewareMerger
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
class MiddlewareMerger
{
    /**
     * @param GlobalMiddlewareInterface[] $global
     * @param MiddlewareInterface[]       $controller
     * @param MiddlewareInterface[]       $action
     * @param MiddlewareInterface[]       $route
     *
     * @return MiddlewareInterface[]
     */
    public function merge(array $global, array $controller, array $action, array $route): array
    {
        return array_values($this->unique(
            array_merge($global, $controller, $action, $route)
        ));
    }

    /**
     * @param MiddlewareInterface[] $middlewares
     *
     * @return MiddlewareInterface[]
     */
    private function unique(array $middlewares): array
    {
        $result = [];

        foreach ($middlewares as $middleware) {
            $result[get_class($middleware)] = $middleware;
        }

        return $result;
    }
}
