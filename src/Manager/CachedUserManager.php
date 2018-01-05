<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Manager;

use Eziat\PermissionBundle\Model\UserManagerAbstract;
use Eziat\PermissionBundle\Model\UserManagerInterface;
use Eziat\PermissionBundle\Model\UserPermissionInterface;
use Eziat\PermissionBundle\Utils\CacheHelperInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class CachedUserManager extends UserManagerAbstract implements UserManagerInterface
{
    /**
     * @var CacheHelperInterface
     */
    private $cacheHelper;

    /**
     * @var string
     */
    private $cachePrefix;

    public function __construct(CacheHelperInterface $cacheHelper, string $cachePrefix )
    {
        $this->cacheHelper = $cacheHelper;
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions(UserPermissionInterface $user) : array
    {
        $cacheID = $this->cachePrefix.$user->getId();
        $permissions = $this->cacheHelper->get($cacheID);
        if ($permissions === null) {
            $permissions = $this->getUserPermissions($user);
            if ( $permissions !== [] ){
                $this->cacheHelper->save($cacheID, $permissions);
            }
        }

        return $permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function invalidatePermissions(UserPermissionInterface $user) : void
    {
        $cacheID = $this->cachePrefix.$user->getId();
        $this->cacheHelper->delete($cacheID);
    }
}