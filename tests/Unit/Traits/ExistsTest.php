<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait ExistsTest
{
    /**
     * @test
     */
    public function key_exists()
    {
        $key = 'bos-14';
        $value = 'w';
        RedisCache::set($key, $value);
        $expected = RedisCache::exists($key);

        $this->assertTrue($expected == true);
    }
}
