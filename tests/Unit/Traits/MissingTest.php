<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait MissingTest
{
    /**
     * @test
     */
    public function is_key_missing()
    {
        $key = 'bos-99';
        $expected = RedisCache::missing($key);

        $this->assertTrue($expected == true);
    }
}
