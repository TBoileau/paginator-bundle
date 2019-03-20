<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PaginatorPass
 *
 * @package TBoileau\Bundle\PaginatorBundle\DependencyInjection\Compiler
 * @author Thomas Boileau <t-boileau@email.com>
 */
class PaginatorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition("t_boileau.paginator.paginator_factory");

        $definition->addMethodCall('setServiceLocator', [$this->processRepresentation($container)]);

        $definition = $container->getDefinition("t_boileau.paginator.paginator_builder");

        $definition->replaceArgument(0, $this->processAction($container));
    }

    /**
     * @param ContainerBuilder $container
     * @return Reference
     */
    private function processAction(ContainerBuilder $container): Reference
    {
        /** @var Reference[] $servicesMap */
        $servicesMap =  [];

        $taggedServices = $container->findTaggedServiceIds("t_boileau.action", true);

        /**
         * @var string $serviceId
         * @var array $taggedServiceId
         */
        foreach ($taggedServices as $serviceId => $taggedServiceId) {
            $servicesMap[$container->getDefinition($serviceId)->getClass()] = new Reference($serviceId);
        }

        return ServiceLocatorTagPass::register($container, $servicesMap);
    }

    /**
     * @param ContainerBuilder $container
     * @return Reference
     */
    private function processRepresentation(ContainerBuilder $container): Reference
    {
        /** @var Reference[] $servicesMap */
        $servicesMap =  [];

        $taggedServices = $container->findTaggedServiceIds("t_boileau.representation", true);

        /**
         * @var string $serviceId
         * @var array $taggedServiceId
         */
        foreach ($taggedServices as $serviceId => $taggedServiceId) {
            $servicesMap[$container->getDefinition($serviceId)->getClass()] = new Reference($serviceId);
        }

        return ServiceLocatorTagPass::register($container, $servicesMap);
    }
}
