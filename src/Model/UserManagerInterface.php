<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Model;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface UserManagerInterface
{
    /**
     * Gets all permissions from user. If it isn't cached it will add a new entry.
     */
    public function getPermissions(UserPermissionInterface $user) : array;

    /**
     * Has the given user the given permissions.
     */
    public function hasPermissions(UserPermissionInterface $user, array $permissions) : bool;

    /**
     * Has the given user the given permission.
     */
    public function hasPermission(UserPermissionInterface $user, $permission) : bool;

    /**
     * Invalidate permissions of the given user.
     */
    public function invalidatePermissions(UserPermissionInterface $user) : void;
}