<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Model;

use Eziat\PermissionBundle\Entity\Permission;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface UserPermissionInterface
{
    /**
     * Get all permissions.
     *
     * @return Permission[]
     */
    public function getPermissions() : array;

    /**
     * Get an id.
     *
     * @return mixed
     */
    public function getId();
}