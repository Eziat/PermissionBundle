<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Model;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface PermissionManagerInterface
{
    /**
     * Creates an empty permission.
     */
    public function createPermission();
    /**
     * Finds one permission by the given criteria.
     */
    public function findPermissionBy(array $criteria);
    /**
     * Gets an permission by the given id.
     */
    public function findPermissionById(int $id) : ?PermissionInterface;
    /**
     * Returns the permission's fully qualified class name.
     */
    public function findPermissions() : array;
    /**
     * Returns the permission's fully qualified class name.
     */
    public function findPermissionsBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null) : array;
    /**
     * Updates an permission.
     */
    public function updatePermission(PermissionInterface $permission, ?bool $andFlush = true);
    /**
     * Deletes an permission.
     */
    public function deletePermission(PermissionInterface $permission);
    /**
     * Returns the permission's fully qualified class name.
     */
    public function getClass() : string;
}