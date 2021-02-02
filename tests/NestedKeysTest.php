<?php

namespace Sfneal\Helpers\Redis\Tests;

use Sfneal\Helpers\Redis\RedisCache;

class NestedKeysTest extends TestCase
{
    public function test_get()
    {
        $key = 'bos:33#pos';
        $value = 'd';
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertEquals($value, $output);
        $this->assertNotEquals($value, RedisCache::get('bos:33'));
    }

    public function test_set()
    {
        $key = 'bos:47#pos';
        $value = 'd';
        $stored = RedisCache::set($key, $value);
        $expected = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertEquals($expected, $value);
        $this->assertNotEquals($expected, RedisCache::get('bos:47'));
    }

    public function test_setMany()
    {
        $array = [
            'bos:37#pos' => 'c',
            'bos:37#name_first' => 'Patrice',
            'bos:37#name_last' => 'Bergeron',
            'bos:37#age' => 34,
        ];
        $output = RedisCache::setMany($array);

        $this->assertSame(array_values($array), $output);
        foreach ($array as $key => $value) {
            $this->assertSame(RedisCache::get($key), $value);
        }
    }

    public function test_expire()
    {
        $key = 'bos:88#pos';
        $value = 'w';
        RedisCache::set($key, $value);
        $stored = RedisCache::expire($key, 1);

        $this->assertTrue($stored);
    }

    public function test_delete_key()
    {
        $array = [
            'bos:63#pos' => 'w',
            'bos:63#name_first' => 'Brad',
            'bos:63#name_last' => 'Marchand',
            'bos:63#age' => 32,
        ];
        RedisCache::setMany($array);

        $key = 'bos:63#age';
        RedisCache::delete($key);

        $this->assertFalse(RedisCache::exists($key));
        $this->assertTrue(RedisCache::exists('bos:63#name_first'));
        $this->assertTrue(RedisCache::missing($key));
    }

    public function test_delete_parent_key()
    {
        $array = [
            'bos:46#pos' => 'c',
            'bos:46#name_first' => 'David',
            'bos:46#name_last' => 'Krejci',
            'bos:46#age' => 35,
        ];
        RedisCache::setMany($array);

        $key = 'bos:46';
        RedisCache::delete($key);

        $this->assertFalse(RedisCache::exists($key));

        // todo: fix this so that the nested keys are deleted
//        foreach (array_keys($array) as $key) {
//            $this->assertTrue(RedisCache::missing($key));
//        }
    }

    public function test_delete_array()
    {
        $array = [
            'bos:73#pos' => 'd',
            'bos:73#name_first' => 'Charlie',
            'bos:73#name_last' => 'McAvoy',
            'bos:73#age' => 23,
            'bos:25#pos' => 'd',
            'bos:25#name_first' => 'Brandon',
            'bos:25#name_last' => 'Carlo',
            'bos:25#age' => 25,
            'bos:55#pos' => 'd',
            'bos:55#name_first' => 'Jeremy',
            'bos:55#name_last' => 'Lauzon',
            'bos:55#age' => 24,
        ];
        RedisCache::setMany($array);

        $keys = ['bos:25', 'bos:55'];
        RedisCache::delete($keys);

        foreach ($keys as $key) {
            $this->assertFalse(RedisCache::exists($key));
            $this->assertTrue(RedisCache::missing($key));
        }
    }

    public function test_exists()
    {
        $key = 'bos:14#pos';
        $value = 'w';
        RedisCache::set($key, $value);
        $exists = RedisCache::exists($key);

        $this->assertTrue($exists);
    }

    public function test_missing()
    {
        $key = 'bos:99';
        $expected = RedisCache::missing($key);

        $this->assertTrue($expected);
    }

    public function test_setIfMissing()
    {
        $key = 'bos:14#pos';
        $value = 'w';
        RedisCache::setIfMissing($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected);

        $output = RedisCache::setIfMissing($key, $value);

        $this->assertFalse($output);
    }

    public function test_increment()
    {
        $key = 'bos:14#age';
        $value = 25;
        RedisCache::set($key, $value);

        $output = RedisCache::get($key);

        $this->assertTrue($output == 25);

        $output = RedisCache::increment($key);
        $this->assertTrue($output == 26);
    }

    public function test_flush()
    {
        $array = [
            'bos:37#pos' => 'c',
            'bos:63#pos' => 'w',
            'bos:88#pos' => 'w',
            'pit:87#pos' => 'c',
            'pit:71#pos' => 'c',
            'pit:58#pos' => 'd',
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
