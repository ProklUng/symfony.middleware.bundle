<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

use Prokl\SymfonyMiddlewareBundle\GlobalMiddlewareInterface;

/**
 * Class GlobalMiddlewareWrapper
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
final class GlobalMiddlewareWrapper
{
    private $middleware;
    private $priority;

    /**
     * GlobalMiddlewareWrapper constructor.
     *
     * @param GlobalMiddlewareInterface $middleware
     * @param integer                   $priority
     */
    public function __construct(GlobalMiddlewareInterface $middleware, int $priority)
    {
        $this->middleware = $middleware;
        $this->priority = $priority;
    }

    public function getMiddleware(): GlobalMiddlewareInterface
    {
        return $this->middleware;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
