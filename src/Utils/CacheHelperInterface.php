<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Utils;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface CacheHelperInterface
{
    /**
     * Invalidate a cache entry identified by the given id.
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function invalidateCache(string $cacheId) : void;

    /**
     * Saves the given entry to the cache.
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function save(string $cacheId, $entry) : void;

    /**
     * Deletes a cache entry.
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function delete(string $cacheId) : void;

    /**
     * Get an entry from the cache.
     *
     * @return mixed|null The unserialized entry.
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function get(string $cacheId);
}