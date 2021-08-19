<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait GetTest
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

        $this->assertTrue($value == $output);
    }
}
