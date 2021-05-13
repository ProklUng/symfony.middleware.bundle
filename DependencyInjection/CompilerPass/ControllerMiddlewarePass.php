<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Prokl\SymfonyMiddlewareBundle\Middleware\MiddlewareEnum;
use Prokl\SymfonyMiddlewareBundle\ServiceLocator\MiddlewareServiceLocator;

/**
 * Class ControllerMiddlewarePass
 * @package Prokl\SymfonyMiddlewareBundle\DependencyInjection\CompilerPass
 */
final class ControllerMiddlewarePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        $def = $container->getDefinition(MiddlewareServiceLocator::class);

        /**
         * @psalm-suppress MixedAssignment
         */
        foreach ($container->findTaggedServiceIds(MiddlewareEnum::CONTROLLER_TAG) as $id => $attributes) {
            if (empty($attributes)) {
                throw new \InvalidArgumentException('Provide at least "middleware" attribute');
            }

            foreach ($attributes as $attribute) {
                if (!array_key_exists('middleware', $attribute)) {
                    throw new \InvalidArgumentException('No "middleware" attribute was found');
                }

                if (array_key_exists('action', $attribute)) {
                    $def->addMethodCall(
                        'addControllerActionMiddleware',
                        [$id, $attribute['action'], new Reference($attribute['middleware'])]
                    );
                } else {
                    $def->addMethodCall(
                        'addControllerMiddleware',
                        [$id, new Reference($attribute['middleware'])]
                    );
                }
            }
        }
    }
}
