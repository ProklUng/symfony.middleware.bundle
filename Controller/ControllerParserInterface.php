<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Controller;

/**
 * Interface ControllerParserInterface
 * @package Prokl\SymfonyMiddlewareBundle\Controller
 */
interface ControllerParserInterface
{
    /**
     * @param callable $controller
     *
     * @return ControllerMetadata
     */
    public function parse(callable $controller): ControllerMetadata;
}
