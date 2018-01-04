<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('eziat_permission');
        $supportedDrivers = ['orm'];
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                    ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('object_manager_name')->defaultNull()->end()
                ->scalarNode('permission_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('permission_manager_class')->defaultValue('eziat_permission.permission_manager.default')->end()

                ->arrayNode('permissions')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('description')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}