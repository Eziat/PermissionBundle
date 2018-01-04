<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Manager\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Eziat\PermissionBundle\Manager\PermissionManager as BasePermissionManager;
use Eziat\PermissionBundle\Model\PermissionInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class PermissionManager extends BasePermissionManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    private $class;

    public function __construct(ObjectManager $om, string $class)
    {
        $this->objectManager = $om;
        $this->class         = $class;
    }

    /**
     * Finds one permission by the given criteria.
     */
    public function findPermissionBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->getClass())->findOneBy($criteria);
    }

    /**
     * Returns the permission's fully qualified class name.
     */
    public function findPermissionsBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null) : array
    {
        return $this->objectManager->getRepository($this->getClass())->findBy($criteria);
    }

    /**
     * Updates an permission.
     */
    public function updatePermission(PermissionInterface $permission, ?bool $andFlush = true)
    {
        $this->objectManager->persist($permission);
        if ( $andFlush === true){
            $this->objectManager->flush();
        }
    }

    /**
     * Deletes an permission.
     */
    public function deletePermission(PermissionInterface $permission, ?bool $andFlush = true)
    {
        $this->objectManager->remove($permission);
        $this->objectManager->flush();
    }

    /**
     * Returns the permission's fully qualified class name.
     */
    public function getClass() : string
    {
        if (false !== strpos($this->class, ':')) {
            $metadata    = $this->objectManager->getClassMetadata($this->class);
            $this->class = $metadata->getName();
        }

        return $this->class;
    }
}