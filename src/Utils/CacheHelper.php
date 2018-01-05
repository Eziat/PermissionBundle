<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Utils;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class CacheHelper implements CacheHelperInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $cacheExpireAt;

    public function __construct(CacheItemPoolInterface $cache, int $cacheExpireAt)
    {
        $this->cache = $cache;
        $this->cacheExpireAt = $cacheExpireAt;
    }

    /**
     * {@inheritdoc}
     */
    public function invalidateCache(string $cacheId) : void
    {
        $this->cache->deleteItem($cacheId);
    }

    /**
     * {@inheritdoc}
     */
    public function save(string $cacheId, $entry) : void
    {
        $cacheItem = $this->cache->getItem($cacheId);
        $cacheItem->set($entry);
        $cacheItem->expiresAfter($this->cacheExpireAt);
        $this->cache->save($cacheItem);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $cacheId) : void
    {
        $this->cache->deleteItem($cacheId);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $cacheId)
    {
        $cacheItem = $this->cache->getItem($cacheId);
        if (!$cacheItem->isHit()) {
            return null;
        } else {
            return $cacheItem->get();
        }
    }
}