<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class KeysTest extends TestCase
{
    /**
     * @test
     */
    public function find_keys_matching_pattern()
    {
        $array = [
            'bos:3#pos' => 'c',
            'bos:3#name_first' => 'Charlie',
            'bos:3#name_last' => 'Coyle',
            'bos:3#age' => 26,
            'bos:12#pos' => 'w',
            'bos:12#name_first' => 'Craig',
            'bos:12#name_last' => 'Smith',
            'bos:12#age' => 32,
        ];
        RedisCache::setMany($array);

        $keys = RedisCache::keys('bos:3');

        $this->assertCount(4, $keys);
        foreach (['bos:3#pos', 'bos:3#name_first', 'bos:3#name_last', 'bos:3#age'] as $key) {
            $this->assertTrue(in_array($key, $keys));
        }
    }
}
