<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Model;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
abstract class UserManagerAbstract implements UserManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function hasPermissions(UserPermissionInterface $user, array $permissions) : bool
    {
        $userPermissions = $this->getPermissions($user);

        foreach ($permissions as $permission) {
            if (!in_array($permission, $userPermissions)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(UserPermissionInterface $user, $permission) : bool
    {
        return $this->hasPermission($user, [$permission]);
    }

    protected function getUserPermissions(UserPermissionInterface $user) : array
    {
        foreach ($user->getPermissions() as $permission) {
            $permissions[] = $permission->getName();
        }

        return $permissions;
    }
}