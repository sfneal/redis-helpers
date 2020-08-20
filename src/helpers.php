<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Sfneal\Helpers\Redis\RedisCache;

// todo: create CacheService & CacheService package?

/**
 * Retrieve a formatted RedisKey with the environment prefix included.
 *
 * @param string $redis_key
 * @return string
 */
function redisKey(string $redis_key)
{
    return RedisCache::key($redis_key);
}

/**
 * Retrieve an array of keys that begin with a prefix.
 *
 * @param string $redis_key_prefix
 * @return mixed list of keys without prefix
 */
function redisKeys(string $redis_key_prefix)
{
    return RedisCache::keys($redis_key_prefix);
}

/**
 * Get items from the cache.
 *
 * @param string $redis_key
 * @return mixed
 */
function redisGet(string $redis_key)
{
    return RedisCache::get($redis_key);
}

/**
 * Put items in the cache with a TTL.
 *
 * Use's environment's REDIS_KEY_EXPIRATION value if $expiration is null.
 *
 * @param string $redis_key
 * @param mixed|null $value
 * @param int|null $expiration
 * @return mixed|null $value
 */
function redisSet(string $redis_key, $value = null, $expiration = null)
{
    return RedisCache::set($redis_key, $value, $expiration);
}

/**
 * Add a TTL attribute (time to live or time til expiration) to a Redis key.
 *
 * @param string $redis_key
 * @param null $expiration
 * @return mixed
 */
function redisExpire(string $redis_key, $expiration = null)
{
    return RedisCache::expire($redis_key, $expiration);
}

/**
 * Delete Redis key's from the Cache.
 *
 * @param $redis_key array|string
 * @return array
 */
function redisDelete($redis_key)
{
    return RedisCache::delete($redis_key);
}

/**
 * Determine if a redis key exists in the cache.
 *
 * @param string $redis_key
 * @return bool
 */
function redisExists(string $redis_key)
{
    return RedisCache::exists($redis_key);
}

/**
 * Determine if a redis key is missing from the cache.
 *
 * @param string $redis_key
 * @return bool
 */
function redisMissing(string $redis_key)
{
    return RedisCache::missing($redis_key);
}

/**
 * Render a view & cache its output for reuse.
 *
 * @param string $redis_key
 * @param string $view
 * @param array $data
 * @param int|null $expiration
 * @return mixed|null
 */
function redisCacheView(string $redis_key, string $view, array $data, int $expiration = null)
{
    return RedisCache::set($redis_key, View::make($view, $data)->render(), $expiration);
}

/**
 * Create a Redis Key with a null value if it is missing.
 *
 * @param string $redis_key
 * @param null $value
 * @param int|null $expiration
 * @return bool
 */
function redisCreateIfMissing(string $redis_key, $value = null, int $expiration = null): bool
{
    return RedisCache::setIfMissing($redis_key, $value, $expiration);
}

/**
 * Increment a Redis Key's value & return the new value.
 *
 * @param string $redis_key
 * @param int $value
 * @param int|null $expiration
 * @return mixed
 */
function redisIncrement(string $redis_key, int $value = 1, int $expiration = null)
{
    return RedisCache::increment($redis_key, $value, $expiration);
}

/**
 * Flush the entire redis cache.
 *
 * @return mixed
 */
function redisFlush()
{
    return Redis::connection('default')->client()->flushAll();
}

/**
 * Flush the redis cache of all keys with environment's prefix.
 *
 * @return array
 */
function redisClearCache()
{
    return redisDelete('');
}


/**
 * Pass a $callback function to be stored in the Cache for an amount of time
 *
 * @param string $key
 * @param int $ttl
 * @param Closure $callback
 * @return mixed
 */
function redisRemember(string $key, int $ttl, Closure $callback)
{
    return Cache::remember($key, $ttl, $callback);
}


/**
 * Pass a $callback function to be stored in the Cache forever
 *
 * @param string $key
 * @param Closure $callback
 * @return mixed
 */
function redisRememberForever(string $key, Closure $callback)
{
    return Cache::rememberForever($key, $callback);
}
