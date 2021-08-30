<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class MissingTest extends TestCase
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
