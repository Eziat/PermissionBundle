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

        if (!empty($config['database'])) {
            $this->loadDoctrine($config['database'], $container, $loader);
        }

        if (!empty($config['cache'])) {
            $this->loadCachedUserManager($config['cache'], $container, $loader);
        } else {
            $this->loadBasicUserManager($container, $loader);
        }

        // Set permissions array.
        $container->setParameter('eziat_permission.permissions', $config['permissions']);
    }

    private function loadBasicUserManager(ContainerBuilder $container, Loader\XmlFileLoader $loader)
    {
        $loader->load('user_manager.xml');
        $container->setAlias('Eziat\PermissionBundle\Model\UserManagerInterface',
            new Alias('eziat_permission.manager.user', true));
    }

    private function loadCachedUserManager(array $config, ContainerBuilder $container, Loader\XmlFileLoader $loader)
    {
        // Sets a correct cache adapter.
        $container->setAlias('eziat_permission.cache_adapter', new Alias('cache.app', false));
        // Sets a cache prefix.
        $container->setParameter('eziat_permission.cache.prefix', $config['cache_prefix']);
        // Sets cache expire parameter.
        $container->setParameter('eziat_permission.cache.expire_at', $config['expires_at']);

        $loader->load('cached_user_manager.xml');
        $container->setAlias('Eziat\PermissionBundle\Model\UserManagerInterface',
            new Alias('eziat_permission.manager.cached_user', true));
    }

    private function loadDoctrine(array $config, ContainerBuilder $container, Loader\XmlFileLoader $loader)
    {
        // Sets permission class parameter.
        $container->setParameter('eziat_permission.model.permission_class', $config['permission_class']);

        // Sets object manager name.
        if ($config['object_manager_name'] === null) {
            $container->setParameter('eziat_permission.model.manager_name', 'default');
        } else {
            $container->setParameter('eziat_permission.model.manager_name', $config['object_manager_name']);
        }

        // Sets permission manager if does not exist.
        if ($config['permission_manager_class'] === null) {
            $container->setParameter('eziat_permission.permission_manager_class', PermissionManager::class);
            $config['permission_manager_class'] = PermissionManager::class;
        } else {
            $container->setParameter('eziat_permission.permission_manager_class', $config['permission_manager_class']);
        }

        // Configure doctrine manager.
        $loader->load('doctrine.xml');
        $container->setAlias('eziat_permission.doctrine_registry', new Alias('doctrine', false));
        $definition = $container->getDefinition('eziat_permission.object_manager');
        $definition->setFactory([new Reference('eziat_permission.doctrine_registry'), 'getManager']);

        // Set a PermissionManagerInterface alias.
        $container->setAlias('eziat_permission.permission_manager',
            new Alias($config['permission_manager_class'], false));
        $container->setAlias('Eziat\PermissionBundle\Model\PermissionManagerInterface',
            new Alias('eziat_permission.permission_manager', false));

        // Set a loader permission.
        $loader->load('loader.xml');
        $container->setAlias('Eziat\PermissionBundle\Loader\PermissionLoaderInterface',
            new Alias('eziat_permission.loader.permission', false));
        $loader->load('command.xml');
    }
}