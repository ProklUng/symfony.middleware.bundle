<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

use Prokl\SymfonyMiddlewareBundle\GlobalMiddlewareInterface;

/**
 * Class GlobalMiddlewareMapper
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
class GlobalMiddlewareMapper
{
    /**
     * @param GlobalMiddlewareWrapper[] $globalMiddlewares
     * @return GlobalMiddlewareInterface[]
     */
    public function fromWrapper(array $globalMiddlewares): array
    {
        return array_map(static function (GlobalMiddlewareWrapper $middleware) {
            return $middleware->getMiddleware();
        }, $globalMiddlewares);
    }
}
