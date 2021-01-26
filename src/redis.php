<?php

use Illuminate\Support\Facades\View;
use Sfneal\Helpers\Redis\RedisCache;

/**
 * Retrieve a formatted RedisKey with the environment prefix included.
 *
 * @param string $key
 * @return string
 */
function redisKey(string $key): string
{
    return RedisCache::key($key);
}

/**
 * Get items from the cache.
 *
 * @param string $key
 * @return mixed
 */
function redisGet(string $key)
{
    return RedisCache::get($key);
}

/**
 * Put items in the cache with a TTL.
 *
 * Use's environment's REDIS_KEY_EXPIRATION value if $expiration is null.
 *
 * @param string $key
 * @param mixed|null $value
 * @param int|null $expiration
 * @return mixed|null $value
 */
function redisSet(string $key, $value = null, $expiration = null)
{
    return RedisCache::set($key, $value, $expiration);
}

/**
 * Add a TTL attribute (time to live or time til expiration) to a Redis key.
 *
 * @param string $key
 * @param null $expiration
 * @return mixed
 */
function redisExpire(string $key, $expiration = null)
{
    return RedisCache::expire($key, $expiration);
}

/**
 * Delete Redis key's from the Cache.
 *
 * @param $key array|string
 * @return array
 */
function redisDelete($key): array
{
    return RedisCache::delete($key);
}

/**
 * Determine if a redis key exists in the cache.
 *
 * @param string $key
 * @return bool
 */
function redisExists(string $key): bool
{
    return RedisCache::exists($key);
}

/**
 * Determine if a redis key is missing from the cache.
 *
 * @param string $key
 * @return bool
 */
function redisMissing(string $key): bool
{
    return RedisCache::missing($key);
}

/**
 * Render a view & cache its output for reuse.
 *
 * @param string $key
 * @param string $view
 * @param array $data
 * @param int|null $expiration
 * @return mixed|null
 */
function redisCacheView(string $key, string $view, array $data, int $expiration = null)
{
    return RedisCache::set($key, View::make($view, $data)->render(), $expiration);
}

/**
 * Create a Redis Key with a null value if it is missing.
 *
 * @param string $key
 * @param null $value
 * @param int|null $expiration
 * @return bool
 */
function redisCreateIfMissing(string $key, $value = null, int $expiration = null): bool
{
    return RedisCache::setIfMissing($key, $value, $expiration);
}

/**
 * Increment a Redis Key's value & return the new value.
 *
 * @param string $key
 * @param int $value
 * @param int|null $expiration
 * @return mixed
 */
function redisIncrement(string $key, int $value = 1, int $expiration = null)
{
    return RedisCache::increment($key, $value, $expiration);
}

/**
 * Flush the entire redis cache.
 *
 * @return mixed
 */
function redisFlush()
{
    return RedisCache::flush();
}

/**
 * Flush the redis cache of all keys with environment's prefix.
 *
 * @return array
 */
function redisClearCache(): array
{
    return RedisCache::clear();
}

/**
 * Pass a $callback function to be stored in the Cache for an amount of time.
 *
 * @param string $key
 * @param int $ttl
 * @param Closure $callback
 * @return mixed
 */
function redisRemember(string $key, int $ttl, Closure $callback)
{
    return RedisCache::remember($key, $ttl, $callback);
}

/**
 * Pass a $callback function to be stored in the Cache forever.
 *
 * @param string $key
 * @param Closure $callback
 * @return mixed
 */
function redisRememberForever(string $key, Closure $callback)
{
    return RedisCache::rememberForever($key, $callback);
}
