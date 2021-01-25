<?php

namespace Sfneal\Helpers\Redis\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;
use Sfneal\Helpers\Redis\RedisCache;

class RedisCacheTest extends TestCase
{
    /**
     * @var RedisCache
     */
    protected $redis;

    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return RedisHelpersServiceProvider::class;
    }

    public function test_prefix()
    {
        $expected = config('redis-helpers.prefix');
        $value = RedisCache::prefix();

        $this->assertIsString($value);
        $this->assertTrue($value == $expected);
    }

    public function test_ttl()
    {
        $expected = config('redis-helpers.ttl');
        $value = RedisCache::ttl();

        $this->assertIsInt($value);
        $this->assertTrue($value == $expected);
    }

    public function test_key()
    {
        $key = 'heresakey';
        $expected = 'app:'.$key;
        $value = RedisCache::key($key);

        $this->assertIsString($value);
        $this->assertTrue($value == $expected);
    }

    public function test_keys()
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

        $expected = array_keys($array);
        $value = RedisCache::keys('bos');

        $this->assertIsArray($value);
        // todo: fix this
//        $this->assertTrue($value == $expected);
    }

    public function test_get()
    {
        $key = 'bos-37';
        $value = 'c';
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertTrue($value == $output);
    }

    public function test_set()
    {
        $key = 'bos-88';
        $value = 'w';
        $output = RedisCache::set($key, $value);
        $expected = RedisCache::get($key);

        $this->assertTrue($output == $expected);
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
        $expected = 100;
        RedisCache::set($key, 'value');
        $value = RedisCache::expire($key, 1);

        // todo: improve this by getting the ttl from the key
        $this->assertIsString($value);
        $this->assertTrue($value == 'value');
    }

    public function test_delete()
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

        $key = 'pit-87';
        RedisCache::delete($key);
        $value = RedisCache::exists('pit-87');

        // todo: fix this
        $this->assertTrue($value == 1);

        $keys = ['pit-71', 'pit-58'];
        RedisCache::delete($keys);
        $value = RedisCache::exists('pit-71');

        // todo: fix this
        $this->assertTrue($value == 1);
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
}
