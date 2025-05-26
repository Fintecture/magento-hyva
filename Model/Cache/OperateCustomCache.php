<?php

declare(strict_types=1);

namespace Fintecture\HyvaPayment\Model\Cache;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class OperateCustomCache
{
    /** @var CacheInterface */
    protected $cache;

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * @param CacheInterface $cache
     * @param SerializerInterface $serializer
     */
    public function __construct(CacheInterface $cache, SerializerInterface $serializer)
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $value
     */
    public function save(string $key, $value, int $duration = 86400): void
    {
        $cacheTag = Type::CACHE_TAG;

        $serializedValue = $this->serializer->serialize($value);
        if (!is_string($serializedValue)) {
            return;
        }

        $this->cache->save(
            $serializedValue,
            $key,
            [$cacheTag],
            $duration
        );
    }

    /**
     * @return mixed
     */
    public function get(string $key)
    {
        $cachedValue = $this->cache->load($key);
        if (!empty($cachedValue)) {
            return $this->serializer->unserialize($cachedValue);
        }

        return null;
    }
}
