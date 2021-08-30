<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class ExistsTest extends TestCase
{
    /**
     * @test
     */
    public function key_exists()
    {
        $key = 'bos-14';
        $value = 'w';
        $wasSet = RedisCache::set($key, $value);
        $actual = RedisCache::exists($key);

        $this->assertTrue($wasSet);
        $this->assertTrue($actual);
    }
}
