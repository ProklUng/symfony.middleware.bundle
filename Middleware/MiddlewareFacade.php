<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Prokl\SymfonyMiddlewareBundle\Controller\ControllerMetadata;
use Prokl\SymfonyMiddlewareBundle\MiddlewareInterface;
use Prokl\SymfonyMiddlewareBundle\ServiceLocator\MiddlewareServiceLocator;

/**
 * Class MiddlewareFacade
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
class MiddlewareFacade
{
    /**
     * @var MiddlewareServiceLocator $middlewareServiceLocator
     */
    private $middlewareServiceLocator;

    /**
     * @var MiddlewareMerger $middlewareMerger
     */
    private $middlewareMerger;

    /**
     * @var GlobalMiddlewareMapper $globalMiddlewareMapper
     */
    private $globalMiddlewareMapper;

    /**
     * @var GlobalMiddlewareWrapperSorter $globalMiddlewareWrapperSorter
     */
    private $globalMiddlewareWrapperSorter;

    /**
     * MiddlewareFacade constructor.
     *
     * @param MiddlewareServiceLocator      $middlewareServiceLocator
     * @param MiddlewareMerger              $middlewareMerger
     * @param GlobalMiddlewareMapper        $globalMiddlewareMapper
     * @param GlobalMiddlewareWrapperSorter $globalMiddlewareWrapperSorter
     */
    public function __construct(
        MiddlewareServiceLocator $middlewareServiceLocator,
        MiddlewareMerger $middlewareMerger,
        GlobalMiddlewareMapper $globalMiddlewareMapper,
        GlobalMiddlewareWrapperSorter $globalMiddlewareWrapperSorter
    ) {
        $this->middlewareServiceLocator = $middlewareServiceLocator;
        $this->middlewareMerger = $middlewareMerger;
        $this->globalMiddlewareMapper = $globalMiddlewareMapper;
        $this->globalMiddlewareWrapperSorter = $globalMiddlewareWrapperSorter;
    }

    /**
     * @param ControllerMetadata $controllerMetadata
     * @param Request            $request
     *
     * @return MiddlewareInterface[]
     */
    public function getMiddlewaresToHandle(ControllerMetadata $controllerMetadata, Request $request): array
    {
        $globalMiddlewares = $this->middlewareServiceLocator->getGlobalMiddlewares();

        $globalMiddlewares = $this->globalMiddlewareWrapperSorter->sortDescByPriority($globalMiddlewares);
        $globalMiddlewares = $this->globalMiddlewareMapper->fromWrapper($globalMiddlewares);

        $controllerActionMiddlewares = $this->middlewareServiceLocator->getControllerActionMiddlewares(
            $controllerMetadata->getControllerFqcn(),
            $controllerMetadata->getControllerAction()
        );

        $controllerMiddlewares = $this->middlewareServiceLocator->getControllerMiddlewares(
            $controllerMetadata->getControllerFqcn()
        );

        $routeMiddlewares = $this->middlewareServiceLocator->getRouteMiddlewares($request->get('_route', ''));

        return $this->middlewareMerger->merge(
            $globalMiddlewares,
            $controllerMiddlewares,
            $controllerActionMiddlewares,
            $routeMiddlewares
        );
    }
}
