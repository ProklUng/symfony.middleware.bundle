<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass\ControllerMiddlewarePass;
use Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass\GlobalMiddlewarePass;
use Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass\RouteMiddlewarePass;
use Prokl\SymfonyMiddlewareBundle\Middleware\MiddlewareEnum;

/**
 * Class MiddlewareBundle
 * @package Prokl\SymfonyMiddlewareBundle
 *
 * @see https://github.com/zholus/symfony-middleware-bundle
 */
class MiddlewareBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(MiddlewareInterface::class)
            ->addTag(MiddlewareEnum::ALIAS_SUFFIX);

        $container->registerForAutoconfiguration(GlobalMiddlewareInterface::class)
            ->addTag(MiddlewareEnum::GLOBAL_TAG);

        $container->addCompilerPass(new GlobalMiddlewarePass());
        $container->addCompilerPass(new ControllerMiddlewarePass());
        $container->addCompilerPass(new RouteMiddlewarePass());
    }
}
