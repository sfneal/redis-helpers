<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class MissingTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function is_key_missing($key, $value)
    {
        $missing = RedisCache::missing($key);

        $this->assertTrue($missing);
    }

    /**
     * @test
     *
     * @dataProvider keyValueProvider
     */
    public function is_key_missing_helper($key, $value)
    {
        $missing = redisMissing($key);

        $this->assertTrue($missing);
    }
}
