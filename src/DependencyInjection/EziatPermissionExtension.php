<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\DependencyInjection;

use Eziat\PermissionBundle\Manager\Doctrine\PermissionManager;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class EziatPermissionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();
        $loader        = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $config = $processor->processConfiguration($configuration, $configs);

        // Sets permission class parameter.
        $container->setParameter('eziat_permission.model.permission_class', $config['permission_class']);

        // Sets object manager name.
        if (!array_key_exists('object_manager_name', $config)) {
            $container->setParameter('eziat_permission.model.manager_name', 'default');
        } else {
            $container->setParameter('eziat_permission.model.manager_name', $config['object_manager_name']);
        }

        // Sets permission manager if does not exist.
        if (array_key_exists('permission_manager_class', $config)) {
            $container->setParameter('eziat_permission.permission_manager_class', $config['permission_manager_class']);
        } else {
            $container->setParameter('eziat_permission.permission_manager_class', PermissionManager::class);
        }

        // Configure doctrine manager.
        $loader->load('doctrine.xml');
        $container->setAlias('eziat_permission.doctrine_registry', new Alias('doctrine', false));
        $definition = $container->getDefinition('eziat_permission.object_manager');
        $definition->setFactory([new Reference('eziat_permission.doctrine_registry'), 'getManager']);

        // Set a PermissionManagerInterface alias.
        $container->setAlias('eziat_permission.permission_manager', new Alias($config['permission_manager_class'], false));
        $container->setAlias('Eziat\PermissionBundle\Model\PermissionManagerInterface', new Alias('eziat_permission.permission_manager', false));
    }
}