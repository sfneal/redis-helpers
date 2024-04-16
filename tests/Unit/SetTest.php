<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class SetTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function set_key_value_pair($key, $value)
    {
        $stored = RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertTrue($stored);
        $this->assertEquals($value, $output);
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
     *
     * @dataProvider keyValueProvider
     */
    public function set_if_key_is_missing($key, $value)
    {
        RedisCache::setIfMissing($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected);

        $output = RedisCache::setIfMissing($key, $value);

        $this->assertFalse($output);
    }

    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function increment_value($key, $value)
    {
        RedisCache::set($key, 1);

        $output = RedisCache::get($key);

        $this->assertTrue($output == 1);

        $output = RedisCache::increment($key);
        $this->assertIsInt($output);
        $this->assertSame(2, $output);
    }
}
