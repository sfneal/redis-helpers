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
        $missing = RedisCache::missing($key);

        $this->assertTrue($missing);
    }
}
