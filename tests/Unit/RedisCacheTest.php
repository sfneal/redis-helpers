<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class RedisCacheTest extends TestCase
{
    public function test_defaultTTL()
    {
        $key = 'bos:52:pos';
        RedisCache::set($key, 'c');
        $ttl = RedisCache::ttl($key);

        $this->assertIsInt($ttl);
        $this->assertEquals(config('redis-helpers.ttl'), $ttl);
    }

    public function test_keys()
    {
        $array = [
            'bos:3#pos' => 'c',
            'bos:3#name_first' => 'Charlie',
            'bos:3#name_last' => 'Coyle',
            'bos:3#age' => 26,
            'bos:12#pos' => 'w',
            'bos:12#name_first' => 'Craig',
            'bos:12#name_last' => 'Smith',
            'bos:12#age' => 32,
        ];
        RedisCache::setMany($array);

        $keys = RedisCache::keys('bos:3');

        $this->assertCount(4, $keys);
        foreach (['bos:3#pos', 'bos:3#name_first', 'bos:3#name_last', 'bos:3#age'] as $key) {
            $this->assertTrue(in_array($key, $keys));
        }
    }

    public function test_get()
    {
        $key = 'bos-33';
        $value = 'd';
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertTrue($value == $output);
    }

    public function test_set()
    {
        $key = 'bos-47';
        $value = 'd';
        $stored = RedisCache::set($key, $value);
        $expected = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertTrue($expected == $value);
    }

    public function test_setMany()
    {
        $array = [
            'bos-37' => 'c',
            'bos-63' => 'w',
            'bos-88' => 'w',
            'pit-87' => 'c',
            'pit-71' => 'c',
            'pit-58' => 'd',
        ];
        $output = RedisCache::setMany($array);

        $this->assertTrue($output == array_values($array));
    }

    public function test_expire()
    {
        $key = 'heresanotherkey';
        $ttl = 100;
        RedisCache::set($key, 'value');
        $stored = RedisCache::expire($key, $ttl);

        $this->assertEquals($ttl, RedisCache::ttl($key));
        $this->assertTrue($stored);
    }

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

    public function test_exists()
    {
        $key = 'bos-14';
        $value = 'w';
        RedisCache::set($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected == true);
    }

    public function test_missing()
    {
        $key = 'bos-99';
        $expected = RedisCache::missing($key);

        $this->assertTrue($expected == true);
    }

    public function test_setIfMissing()
    {
        $key = 'bos-14';
        $value = 'w';
        RedisCache::setIfMissing($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected == true);

        $output = RedisCache::setIfMissing($key, $value);

        $this->assertTrue($output == false);
    }

    public function test_increment()
    {
        $key = 'bos-54';
        $value = 1;
        RedisCache::set($key, $value);

        $output = RedisCache::get($key);

        $this->assertTrue($output == 1);

        $output = RedisCache::increment($key);
        $this->assertTrue($output == 2);
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

    public function test_remember()
    {
        $key = 'keytoremember';
        RedisCache::remember($key, 100, function () {
            return md5(random_int(1000, 2000));
        });

        $this->assertTrue(RedisCache::exists($key));
    }

    public function test_rememberForever()
    {
        $key = 'keytorememberforever';
        RedisCache::rememberForever($key, function () {
            return md5(random_int(2000, 3000));
        });

        $this->assertTrue(RedisCache::exists($key));
    }
}
