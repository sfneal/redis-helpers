<?php

namespace Sfneal\Helpers\Redis\Tests\Unit\Traits;

use Sfneal\Helpers\Redis\RedisCache;

trait RememberTest
{
    /**
     * @test
     */
    public function remember()
    {
        $key = 'keytoremember';
        RedisCache::remember($key, 100, function () {
            return md5(random_int(1000, 2000));
        });

        $this->assertTrue(RedisCache::exists($key));
    }

    public function remember_forever()
    {
        $key = 'keytorememberforever';
        RedisCache::rememberForever($key, function () {
            return md5(random_int(2000, 3000));
        });

        $this->assertTrue(RedisCache::exists($key));
    }
}
