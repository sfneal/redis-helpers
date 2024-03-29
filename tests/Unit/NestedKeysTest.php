<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class NestedKeysTest extends TestCase
{
    /** @test */
    public function nested_get()
    {
        $key = 'bos:33#pos';
        $value = 'd';
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertEquals($value, $output);
        $this->assertNotEquals($value, RedisCache::get('bos:33'));
    }

    /** @test */
    public function nested_set()
    {
        $key = 'bos:47#pos';
        $value = 'd';
        $stored = RedisCache::set($key, $value);
        $expected = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertEquals($expected, $value);
        $this->assertNotEquals($expected, RedisCache::get('bos:47'));
    }

    /** @test */
    public function nested_setMany()
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
            $this->assertEquals(RedisCache::get($key), $value);
        }
    }

    /** @test */
    public function nested_expire()
    {
        $key = 'bos:88#pos';
        $value = 'w';
        RedisCache::set($key, $value);
        $stored = RedisCache::expire($key, 1);

        $this->assertTrue($stored);
    }

    /** @test */
    public function nested_delete_key()
    {
        $array = [
            'bos:63#pos' => 'w',
            'bos:63#name_first' => 'Brad',
            'bos:63#name_last' => 'Marchand',
            'bos:63#age' => 32,
        ];
        RedisCache::setMany($array);

        $key = 'bos:63#pos';
        $this->assertTrue(RedisCache::exists($key));
        $deleted = RedisCache::delete($key);

        $this->assertEquals(['bos:63#pos' => true], $deleted);

        $this->assertFalse(RedisCache::exists($key));
        $this->assertTrue(RedisCache::exists('bos:63#name_first'));
        $this->assertTrue(RedisCache::missing($key));
    }

    /** @test */
    public function nested_delete_parent_key()
    {
        $array = [
            'bos:46#pos' => 'c',
            'bos:46#name_first' => 'David',
            'bos:46#name_last' => 'Krejci',
            'bos:46#age' => 35,
        ];
        RedisCache::setMany($array);

        $key = 'bos:46';
        $deleted = RedisCache::delete($key);

        $this->assertEquals(array_fill_keys(array_keys($array), 1), $deleted);
        $this->assertFalse(RedisCache::exists($key));

        foreach (array_keys($array) as $key) {
            $this->assertTrue(RedisCache::missing($key));
        }
    }

    /** @test */
    public function nested_delete_array()
    {
        $toDelete = [
            'bos:25#pos' => 'd',
            'bos:25#name_first' => 'Brandon',
            'bos:25#name_last' => 'Carlo',
            'bos:25#age' => 25,
            'bos:55#pos' => 'd',
            'bos:55#name_first' => 'Jeremy',
            'bos:55#name_last' => 'Lauzon',
            'bos:55#age' => 24,
        ];
        $keep = [
            'bos:73#pos' => 'd',
            'bos:73#name_first' => 'Charlie',
            'bos:73#name_last' => 'McAvoy',
            'bos:73#age' => 23,
        ];
        RedisCache::setMany(array_merge($toDelete, $keep));

        $keys = ['bos:25', 'bos:55'];
        RedisCache::delete($keys);

        foreach (array_keys($toDelete) as $key) {
            $this->assertFalse(RedisCache::exists($key));
            $this->assertTrue(RedisCache::missing($key));
        }

        foreach (array_keys($keep) as $key) {
            $this->assertTrue(RedisCache::exists($key));
            $this->assertFalse(RedisCache::missing($key));
        }
    }

    /** @test */
    public function nested_exists()
    {
        $key = 'bos:14#pos';
        $value = 'w';
        RedisCache::set($key, $value);
        $exists = RedisCache::exists($key);

        $this->assertTrue($exists);
    }

    /** @test */
    public function nested_missing()
    {
        $key = 'bos:99';
        $expected = RedisCache::missing($key);

        $this->assertTrue($expected);
    }

    /** @test */
    public function nested_setIfMissing()
    {
        $key = 'bos:14#pos';
        $value = 'w';
        RedisCache::setIfMissing($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected);

        $output = RedisCache::setIfMissing($key, $value);

        $this->assertFalse($output);
    }

    /** @test */
    public function nested_increment()
    {
        $key = 'bos:14#age';
        $value = 25;
        RedisCache::set($key, $value);

        $output = RedisCache::get($key);

        $this->assertEquals(25, $output);

        $output = RedisCache::increment($key);
        $this->assertEquals(26, $output);
    }

    /** @test */
    public function nested_flush()
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

        Cache::flush();

        foreach ($array as $key => $value) {
            $this->assertTrue(RedisCache::missing($key));
        }
    }
}
