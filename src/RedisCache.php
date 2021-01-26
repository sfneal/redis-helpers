<?php

namespace Sfneal\Helpers\Redis;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Sfneal\Actions\AbstractService;

class RedisCache extends AbstractService
{
    /**
     * Retrieve the Redis Key prefix from the config.
     *
     * @return string
     */
    public static function prefix(): string
    {
        return config('redis-helpers.prefix', 'app');
    }

    /**
     * Retrieve the Redis Key TTL from the config.
     *
     * @return int
     */
    public static function ttl(): int
    {
        return config('redis-helpers.ttl', 3600);
    }

    /**
     * Retrieve a formatted RedisKey with the environment prefix included.
     *
     * @param string $key
     * @return string
     */
    public static function key(string $key): string
    {
        return self::prefix().":$key";
    }

    /**
     * Retrieve an array of keys that begin with a prefix.
     *
     * @param string $prefix
     * @return mixed list of keys without prefix
     */
    public static function keys(string $prefix)
    {
        // todo: fix this method
        return array_map(
            // Remove prefix from each key so it is not concatenated twice
            function ($key) {
                return substr($key, strlen(self::prefix()) + 1);
            },

            // List of Redis key's matching pattern
            Redis::connection()->client()->keys(self::key($prefix.'*'))
        );
    }

    /**
     * Get items from the cache.
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return Cache::get(self::key($key));
    }

    /**
     * Put items in the cache with a TTL.
     *
     * Use's environment's REDIS_KEY_EXPIRATION value if $expiration is null.
     *
     * @param string $key
     * @param null $value
     * @param int|null $expiration
     * @return string
     */
    public static function set(string $key, $value = null, int $expiration = null)
    {
        // Store the $value in the Cache
        // todo: change return type to pull
        Cache::put(
            self::key($key),
            $value,
            (isset($expiration) ? $expiration : self::ttl())
        );

        // Return the $value
        return $value;
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
     * @return string|null
     */
    public static function expire(string $key, $expiration = null)
    {
        // Use environment REDIS_KEY_EXPIRATION value if not set
        if (! $expiration) {
            $expiration = self::ttl();
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
     * @param $key array|string
     * @return mixed
     */
    public static function delete($key)
    {
        // todo: fix issues with not deleting?
        // Empty array of keys to delete
        $keys = [];

        // Check if an array of keys has been passed
        if (gettype($key) == 'array') {
            // Recursively merge arrays of keys found matching pattern
            foreach (array_values($key) as $value) {
                $keys = array_merge($keys, self::keys($value));
            }
        } else {
            // All keys matching pattern
            $keys = array_merge($keys, self::keys($key));
        }

        // Remove all keys that match param patterns
        $to_remove = array_values($keys);
        foreach ($to_remove as $value) {
            Cache::forget($value);
        }

        // Return array of deleted keys
        return array_values($to_remove);
    }

    /**
     * Determine if a redis key exists in the cache.
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return Cache::has(self::key($key));
    }

    /**
     * Determine if a redis key is missing from the cache.
     *
     * @param string $key
     * @return bool
     */
    public static function missing(string $key): bool
    {
        return Cache::missing(self::key($key));
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

        // Increment the value
        Cache::increment(self::key($key), $value);

        // Return the new value
        // todo: check if this is needed
        return self::get($key);
    }

    /**
     * Flush the entire redis cache.
     *
     * @return mixed
     */
    public static function flush()
    {
        return Redis::connection()->client()->flushAll();
    }

    /**
     * Flush the redis cache of all keys with environment's prefix.
     *
     * @return mixed
     */
    public static function clear()
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
