<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait DeleteTest
{
    public function test_delete_key()
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
        RedisCache::delete($key);

        $this->assertFalse(RedisCache::exists($key));
        $this->assertTrue(RedisCache::missing($key));
    }

    public function test_delete_array()
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
        RedisCache::delete($keys);

        foreach ($keys as $key) {
            $this->assertFalse(RedisCache::exists($key));
            $this->assertTrue(RedisCache::missing($key));
        }
    }

    public function test_flush()
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
            $this->assertTrue(RedisCache::exists($key));
        }

        RedisCache::flush();

        foreach ($array as $key => $value) {
            $this->assertTrue(RedisCache::missing($key));
        }
    }
}
