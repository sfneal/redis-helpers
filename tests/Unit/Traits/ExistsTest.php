<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait ExistsTest
{
    public function test_exists()
    {
        $key = 'bos-14';
        $value = 'w';
        RedisCache::set($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected == true);
    }
}
