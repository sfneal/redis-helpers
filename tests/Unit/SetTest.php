<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class SetTest extends TestCase
{
    /**
     * @test
     */
    public function set_key_value_pair()
    {
        $key = 'bos-47';
        $value = 'd';
        $stored = RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertSame($value, $output);
    }

    /**
     * @test
     */
    public function set_multiple_key_value_pair()
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

        $this->assertSame(array_values($array), $output);
    }

    /**
     * @test
     */
    public function set_if_key_is_missing()
    {
        $key = 'bos-14';
        $value = 'w';
        RedisCache::setIfMissing($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected == true);

        $output = RedisCache::setIfMissing($key, $value);

        $this->assertFalse($output);
    }

    /**
     * @test
     */
    public function increment_value()
    {
        $key = 'bos-54';
        $value = 1;
        RedisCache::set($key, $value);

        $output = RedisCache::get($key);

        $this->assertTrue($output == 1);

        $output = RedisCache::increment($key);
        $this->assertSame(2, $output);
    }
}
