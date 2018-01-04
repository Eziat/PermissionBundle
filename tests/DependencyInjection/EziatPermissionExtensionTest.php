<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Test;

use Eziat\PermissionBundle\DependencyInjection\EziatPermissionExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class EziatPermissionExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    protected function tearDown()
    {
        unset($this->configuration);
    }

     public function testNotHasDatabase()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new EziatPermissionExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('permission_manager_class');
    }

    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id)
            ?: $this->configuration->hasAlias($id)));
    }

    protected function createFullConfiguration()
    {
        $this->createConfiguration($this->getFullConfig());
    }

    protected function createEmptyConfiguration()
    {
        $this->createConfiguration($this->getEmptyConfig());
    }

    protected function createDatabaseEmptyConfiguration()
    {
        $this->createConfiguration($this->getEmptyDatabaseConfig());
    }

    protected function createConfiguration(array $config)
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new EziatPermissionExtension();
        $loader->load([$config], $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    protected function getEmptyConfig() : array
    {
        $yaml   = <<<EOF
permissions:
    - { name: "Test permission", description: "Test permission description" }
    - { name: "Test permission 2" }
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getEmptyDatabaseConfig() : array
    {
        $yaml   = <<<EOF
database: 
    db_driver: orm 
    permission_class: Acme\Entity\Permission
permissions:
    - { name: "Test permission", description: "Test permission description" }
    - { name: "Test permission 2" }
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getFullConfig() : array
    {
        $yaml   = <<<EOF
database: 
    db_driver: orm 
    permission_class: Acme\Entity\Permission
    object_manager_name: not_default
    object_manager_class: Acme\Entity\PermissionManager
permissions:
    - { name: "Test permission", description: "Test permission description" }
    - { name: "Test permission 2" }
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}