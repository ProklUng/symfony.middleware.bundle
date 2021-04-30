<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

/**
 * Class GlobalMiddlewareWrapperSorter
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
class GlobalMiddlewareWrapperSorter
{
    /**
     * @param GlobalMiddlewareWrapper[] $globalMiddlewares
     *
     * @return GlobalMiddlewareWrapper[]
     */
    public function sortDescByPriority(array $globalMiddlewares): array
    {
        $result = $globalMiddlewares;

        usort($result, static function (GlobalMiddlewareWrapper $a, GlobalMiddlewareWrapper $b) {
            return $b->getPriority() <=> $a->getPriority();
        });

        return $result;
    }
}
