<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class GetTest extends TestCase
{
    /**
     * @test
     */
    public function get_keys_value()
    {
        $key = 'bos-33';
        $value = 'd';
        RedisCache::set($key, $value);
        $output = RedisCache::get($key);

        $this->assertSame($value, $output);
    }
}
