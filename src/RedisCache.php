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
            Redis::connection('default')->client()->keys(redisKey($prefix.'*'))
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
}
