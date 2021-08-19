<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait MissingTest
{
    public function test_missing()
    {
        $key = 'bos-99';
        $expected = RedisCache::missing($key);

        $this->assertTrue($expected == true);
    }
}
