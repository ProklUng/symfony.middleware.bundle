<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Controller;

/**
 * Class ControllerMetadata
 * @package Prokl\SymfonyMiddlewareBundle\Controller
 */
final class ControllerMetadata
{
    /**
     * @var string $controllerFqcn
     */
    private $controllerFqcn;

    /**
     * @var string $controllerAction
     */
    private $controllerAction;

    /**
     * ControllerMetadata constructor.
     *
     * @param string $controllerFqcn
     * @param string $controllerAction
     */
    public function __construct(string $controllerFqcn, string $controllerAction)
    {
        $this->controllerFqcn = $controllerFqcn;
        $this->controllerAction = $controllerAction;
    }

    /**
     * @return string
     */
    public function getControllerFqcn(): string
    {
        return $this->controllerFqcn;
    }

    /**
     * @return string
     */
    public function getControllerAction(): string
    {
        return $this->controllerAction;
    }
}
