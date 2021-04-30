<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Controller;

/**
 * Class ControllerParser
 * @package Prokl\SymfonyMiddlewareBundle\Controller
 */
final class ControllerParser implements ControllerParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(callable $controller): ControllerMetadata
    {
        if (is_array($controller)) {
            return new ControllerMetadata(get_class($controller[0]), $controller[1]);
        }

        return new ControllerMetadata(get_class($controller), '__invoke');
    }
}
