<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Prokl\SymfonyMiddlewareBundle\Middleware\MiddlewareEnum;
use Prokl\SymfonyMiddlewareBundle\ServiceLocator\MiddlewareServiceLocator;

/**
 * Class RouteMiddlewarePass
 * @package Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass
 */
final class RouteMiddlewarePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        $def = $container->getDefinition(MiddlewareServiceLocator::class);

        $def->addMethodCall('addRouteMiddlewares', [new Reference('router.default')]);

        /**
         * @var string $id
         */
        foreach ($container->findTaggedServiceIds(MiddlewareEnum::ALIAS_SUFFIX) as $id => $arguments) {
            $container->setAlias($id . MiddlewareEnum::ALIAS_SUFFIX, $id)->setPublic(true);
        }
    }
}
