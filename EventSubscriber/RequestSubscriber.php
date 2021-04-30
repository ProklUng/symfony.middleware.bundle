<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Prokl\SymfonyMiddlewareBundle\Controller\ControllerParserInterface;
use Prokl\SymfonyMiddlewareBundle\Middleware\MiddlewareFacade;

/**
 * Class RequestSubscriber
 * @package Prokl\SymfonyMiddlewareBundle\EventSubscriber
 */
final class RequestSubscriber implements EventSubscriberInterface
{
    private $controllerParser;
    private $middlewareFacade;

    /**
     * RequestSubscriber constructor.
     *
     * @param ControllerParserInterface $controllerParser
     * @param MiddlewareFacade          $middlewareFacade
     */
    public function __construct(
        ControllerParserInterface $controllerParser,
        MiddlewareFacade $middlewareFacade
    ) {
        $this->controllerParser = $controllerParser;
        $this->middlewareFacade = $middlewareFacade;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onControllerExecute', 0],
            ]
        ];
    }

    /**
     * @param ControllerEvent $event
     *
     * @return void
     */
    public function onControllerExecute(ControllerEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $controller = $event->getController();

        $controllerMetadata = $this->controllerParser->parse($controller);

        $middlewares = $this->middlewareFacade->getMiddlewaresToHandle($controllerMetadata, $request);

        foreach ($middlewares as $middleware) {
            $middlewareResponse = $middleware->handle($request);
            if ($middlewareResponse !== null) {
                $event->setController(static function () use ($middlewareResponse) {
                    return $middlewareResponse;
                });
                break;
            }
        }
    }
}
