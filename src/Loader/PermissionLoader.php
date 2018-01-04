<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Loader;

use Eziat\PermissionBundle\Model\PermissionInterface;
use Eziat\PermissionBundle\Model\PermissionManagerInterface;

/**
 * Load permissions to the database.
 *
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class PermissionLoader implements PermissionLoaderInterface
{
    /**
     * @var PermissionManagerInterface
     */
    private $permissionManager;

    /**
     * @var array
     */
    private $permissions;

    public function __construct(PermissionManagerInterface $permissionManager, array $permissions)
    {
        $this->permissionManager = $permissionManager;
        $this->permissions = $permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function loadPermissions() : void
    {
        $persistedPermission = null;
        foreach ($this->permissions as $permission) {
            if ( $this->permissionManager->findPermissionBy(['name' => $permission['name']]) === null) {
                /** @var PermissionInterface $newPermission */
                $newPermission = $this->permissionManager->createPermission();
                $newPermission->setName($permission['name']);
                $newPermission->setDescription($permission['description']);
                $this->permissionManager->updatePermission($newPermission, false);
                $persistedPermission = $newPermission;
            }
        }
        if ( $persistedPermission !== null ){
            $this->permissionManager->updatePermission($newPermission);
        }
    }
}