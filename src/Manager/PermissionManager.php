<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Manager;

use Eziat\PermissionBundle\Model\PermissionInterface;
use Eziat\PermissionBundle\Model\PermissionManagerInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
abstract class PermissionManager implements PermissionManagerInterface
{
    /**
     * Creates an empty permission.
     */
    public function createPermission()
    {
        $class      = $this->getClass();
        $permission = new $class();

        return $permission;
    }

    /**
     * Gets an permission by the given id.
     */
    public function findPermissionById(int $id) : ?PermissionInterface
    {
        return $this->findPermissionBy(['id' => $id]);
    }

    /**
     * Returns the permission's fully qualified class name.
     */
    public function findPermissions() : array
    {
        return $this->findPermissionsBy([]);
    }
}