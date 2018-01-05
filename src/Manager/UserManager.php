<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Manager;

use Eziat\PermissionBundle\Model\UserManagerAbstract;
use Eziat\PermissionBundle\Model\UserManagerInterface;
use Eziat\PermissionBundle\Model\UserPermissionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class UserManager extends UserManagerAbstract implements UserManagerInterface
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        parent::__construct($tokenStorage);
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions(UserPermissionInterface $user = null) : array
    {
        return $this->getUserPermissions($user);
    }


    /**
     * {@inheritdoc}
     */
    public function invalidatePermissions(UserPermissionInterface $user) : void
    {
    }
}