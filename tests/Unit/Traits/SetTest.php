<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait SetTest
{
    /**
     * @test
     */
    public function set_key_value_pair()
    {
        $key = 'bos-47';
        $value = 'd';
        $stored = RedisCache::set($key, $value);
        $expected = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertTrue($expected == $value);
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

        $this->assertTrue($output == array_values($array));
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

        $this->assertTrue($output == false);
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
        $this->assertTrue($output == 2);
    }
}
