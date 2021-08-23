<?php

namespace Sfneal\Helpers\Redis;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisCache
{
    /**
     * Retrieve the Redis Key TTL from the config.
     *
     * @return int
     */
    private static function defaultTTL(): int
    {
        return config('redis-helpers.ttl', 3600);
    }

    /**
     * Retrieve a key's time to live in seconds.
     *
     * @param string $key
     * @return int
     */
    public static function ttl(string $key): int
    {
        return Redis::connection()->command('TTL', [$key]);
    }

    /**
     * Retrieve an array of keys that begin with a prefix.
     *
     * @param string $prefix
     * @param bool $wildcard
     * @return mixed list of keys without prefix
     */
    public static function keys(string $prefix = '', bool $wildcard = true)
    {
        return Redis::connection()
            ->client()
            ->keys($prefix.($wildcard ? '*' : ''));
    }

    /**
     * Get items from the cache.
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Put items in the cache with a TTL.
     *
     * Use's environment's REDIS_KEY_EXPIRATION value if $expiration is null.
     *
     * @param string $key
     * @param null $value
     * @param int|null $expiration
     * @return bool
     */
    public static function set(string $key, $value = null, int $expiration = null): bool
    {
        // Store the $value in the Cache
        // todo: optimize expiration call
        return Cache::put(
            $key,
            $value,
            $expiration ?? self::defaultTTL()
        );
    }

    /**
     * Put an array of key value pairs into the cache with a TTL.
     *
     * @param array $array
     * @param int|null $expiration
     * @return array
     */
    public static function setMany(array $array, int $expiration = null): array
    {
        foreach ($array as $key => $value) {
            self::set($key, $value, $expiration);
        }

        return array_values($array);
    }

    /**
     * Add a TTL attribute (time to live or time til expiration) to a Redis key.
     *
     * @param string $key
     * @param null $expiration
     * @return bool
     */
    public static function expire(string $key, $expiration = null): bool
    {
        // Use environment REDIS_KEY_EXPIRATION value if not set
        if (! $expiration) {
            $expiration = self::defaultTTL();
        }

        // Create a key value pair with a null value and a TTL if the key is missing
        if (self::missing($key)) {
            return self::set($key, null, $expiration);
        }

        // Create a key value pair with original value and a TTL if the key exists
        else {
            return self::set($key, self::get($key), $expiration);
        }
    }

    /**
     * Delete Redis key's from the Cache.
     *
     * @param $keys array|string
     * @param bool $children
     * @return array
     */
    public static function delete($keys, bool $children = true): array
    {
        $deleted = [];
        foreach ((array) $keys as $key) {
            $deleted[$key] = Cache::forget($key);
        }
        return $deleted;
    }

    /**
     * Determine if a redis key exists in the cache.
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Determine if a redis key is missing from the cache.
     *
     * @param string $key
     * @return bool
     */
    public static function missing(string $key): bool
    {
        return Cache::missing($key);
    }

    /**
     * Create a Redis Key with a null value if it is missing.
     *
     * @param string $key
     * @param null $value
     * @param null $expiration
     * @return bool
     */
    public static function setIfMissing(string $key, $value = null, $expiration = null): bool
    {
        // Create the redis Key with an expiration
        if (self::missing($key)) {
            self::set($key, $value, $expiration);

            return true;
        }

        // Not created
        return false;
    }

    /**
     * Increment a Redis Key's value & return the new value.
     *
     * @param string $key
     * @param int $value
     * @param int|null $expiration
     * @return mixed
     */
    public static function increment(string $key, int $value = 1, int $expiration = null)
    {
        // Create the Key if it's missing
        self::setIfMissing($key, 0, $expiration);

        // Increment the value & return the new value
        return Cache::increment($key, $value);
    }

    /**
     * Flush the entire redis cache.
     *
     * @return mixed
     */
    public static function flush()
    {
        return Cache::flush();
    }

    /**
     * Flush the redis cache of all keys with environment's prefix.
     *
     * @return array
     */
    public static function clear(): array
    {
        return self::delete('');
    }

    /**
     * Pass a $callback function to be stored in the Cache for an amount of time.
     *
     * @param string $key
     * @param int $ttl
     * @param Closure $callback
     * @return mixed
     */
    public static function remember(string $key, int $ttl, Closure $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Pass a $callback function to be stored in the Cache forever.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     */
    public static function rememberForever(string $key, Closure $callback)
    {
        return Cache::rememberForever($key, $callback);
    }
}
