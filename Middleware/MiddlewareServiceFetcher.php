<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Prokl\SymfonyMiddlewareBundle\MiddlewareInterface;

/**
 * Class MiddlewareServiceFetcher
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
class MiddlewareServiceFetcher
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * MiddlewareServiceFetcher constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    /**
     * @param string[] $middlewares
     *
     * @return MiddlewareInterface[]
     */
    public function fetchServices(array $middlewares): array
    {
        $result = [];

        foreach ($middlewares as $middleware_id) {
            $middleware = $this->container->get($middleware_id . MiddlewareEnum::ALIAS_SUFFIX);

            if (!$middleware instanceof MiddlewareInterface) {
                throw new \LogicException(
                    sprintf('Middleware [%s] must be instance of [%s]', $middleware_id, MiddlewareInterface::class)
                );
            }

            $result[] = $middleware;
        }

        return $result;
    }
}
