<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Route;

use Symfony\Component\Routing\Route;

/**
 * Class RouteWrapper
 *
 * @package Prokl\SymfonyMiddlewareBundle\Route
 */
final class RouteWrapper
{
    /**
     * @var Route|null $originalRoute
     */
    private $originalRoute;

    /**
     * @var string|null $routeName
     */
    private $routeName;

    /**
     * RouteWrapper constructor.
     *
     * @param Route|null  $originalRoute
     * @param string|null $routeName
     */
    public function __construct(?Route $originalRoute, ?string $routeName)
    {
        $this->originalRoute = $originalRoute;
        $this->routeName = $routeName;
    }

    /**
     * @return Route|null
     */
    public function getOriginalRoute(): ?Route
    {
        return $this->originalRoute;
    }

    /**
     * @return string|null
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }
}
