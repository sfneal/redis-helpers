<?php


namespace Sfneal\Helpers\Redis;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Sfneal\Actions\AbstractService;

class RedisCache extends AbstractService
{
    /**
     * Retrieve a formatted RedisKey with the environment prefix included.
     *
     * @param string $key
     * @return string
     */
    public static function key(string $key): string
    {
        return env('REDIS_KEY_PREFIX', 'app').":$key";
    }

    /**
     * Retrieve an array of keys that begin with a prefix.
     *
     * @param string $prefix
     * @return mixed list of keys without prefix
     */
    public static function keys(string $prefix): string
    {
        return array_map(
        // Remove prefix from each key so it is not concatenated twice
            function ($key) {
                return substr($key, strlen(env('REDIS_KEY_PREFIX')) + 1);
            },

            // List of Redis key's matching pattern
            Redis::connection('default')->client()->keys(self::key($prefix.'*'))
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
     * @param null $expiration
     * @return string
     */
    public static function set(string $key, $value = null, $expiration = null)
    {
        // Store the $value in the Cache
        Cache::put(
            $key,
            $value,
            (isset($expiration) ? $expiration : env('REDIS_KEY_EXPIRATION', 3600))
        );

        // Return the $value
        return $value;
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
        if (!$expiration) {
            $expiration = env('REDIS_KEY_EXPIRATION', 3600);
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
}
