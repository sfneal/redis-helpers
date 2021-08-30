<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     */
    public function delete_single_key()
    {
        $array = [
            'phi-93' => 'c',
            'phi-13' => 'w',
            'phi-28' => 'w',
            'pit-59' => 'c',
            'pit-17' => 'c',
            'pit-13' => 'd',
        ];
        RedisCache::setMany($array);

        $key = 'pit-13';
        $deleted = RedisCache::delete($key);

        $this->assertIsArray($deleted);
        $this->assertArrayHasKey($key, $deleted);
        $this->assertTrue($deleted[$key], "'{$key}' was properly deleted.");

        $this->assertFalse(RedisCache::exists($key), "'{$key}' does exist.");
        $this->assertTrue(RedisCache::missing($key), "'{$key}' is not missing.");
    }

    /**
     * @test
     */
    public function delete_multiple_keys()
    {
        $array = [
            'bos-37' => 'c',
            'bos-63' => 'w',
            'bos-88' => 'w',
            'pit-87' => 'c',
            'pit-71' => 'c',
            'pit-58' => 'd',
        ];
        RedisCache::setMany($array);

        $keys = ['pit-71', 'pit-58'];
        $deleted = RedisCache::delete($keys);

        $this->assertIsArray($deleted);

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $deleted);
            $this->assertTrue($deleted[$key], "'{$key}' was properly deleted.");

            $this->assertFalse(RedisCache::exists($key), "'{$key}' does exist.");
            $this->assertTrue(RedisCache::missing($key), "'{$key}' is not missing.");
        }
    }

    /**
     * @test
     */
    public function flush_cache()
    {
        $array = [
            'bos-37' => 'c',
            'bos-63' => 'w',
            'bos-88' => 'w',
            'pit-87' => 'c',
            'pit-71' => 'c',
            'pit-58' => 'd',
        ];
        RedisCache::setMany($array);

        foreach ($array as $key => $value) {
            $this->assertTrue(RedisCache::exists($key), "'{$key}' does not exist.");
        }

        RedisCache::flush();

        foreach ($array as $key => $value) {
            $this->assertTrue(RedisCache::missing($key), "'{$key}' is not missing.");
        }
    }
}
