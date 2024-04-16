<?php

namespace Sfneal\Helpers\Redis\Tests\Unit;

use Sfneal\Helpers\Redis\RedisCache;
use Sfneal\Helpers\Redis\Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider deleteKeysProvider
     */
    public function delete_single_key(array $array)
    {
        RedisCache::setMany($array);

        $key = array_rand($array);
        $deleted = RedisCache::delete($key);

        $this->assertDeletedKey($deleted, $key);
    }

    /**
     * @test
     *
     * @dataProvider deleteKeysProvider
     */
    public function delete_multiple_keys(array $array)
    {
        RedisCache::setMany($array);

        $keys = array_rand($array, rand(2, count($array) - 1));
        $deleted = RedisCache::delete($keys);

        $this->assertDeletedKeys($deleted, $keys);
    }

    /**
     * @test
     *
     * @dataProvider deleteKeysProvider
     */
    public function delete_single_key_helper(array $array)
    {
        RedisCache::setMany($array);

        $key = array_rand($array);
        $deleted = redisDelete($key);

        $this->assertDeletedKey($deleted, $key);
    }

    /**
     * @test
     *
     * @dataProvider deleteKeysProvider
     */
    public function delete_multiple_keys_helper(array $array)
    {
        RedisCache::setMany($array);

        $keys = array_rand($array, rand(2, count($array) - 1));
        $deleted = redisDelete($keys);

        $this->assertDeletedKeys($deleted, $keys);
    }

    /**
     * Retrieve an array of key values pairs to be used when testing key deleting.
     *
     * @return string[][][]
     */
    public static function deleteKeysProvider(): array
    {
        return [
            [[
                'phi-93' => 'c',
                'phi-13' => 'w',
                'phi-28' => 'w',
                'pit-59' => 'c',
                'pit-17' => 'c',
                'pit-13' => 'd',
            ]],
            [[
                'bos-37' => 'c',
                'bos-63' => 'w',
                'bos-88' => 'w',
                'pit-87' => 'c',
                'pit-71' => 'c',
                'pit-58' => 'd',
            ]],
        ];
    }

    /**
     * Execute assertions to confirm a single key was deleted.
     *
     * @param  $deleted
     * @param  $key
     */
    public function assertDeletedKey($deleted, $key): void
    {
        $this->assertIsString($key);
        $this->assertArrayHasKey($key, $deleted);
        $this->assertTrue($deleted[$key], "'{$key}' was properly deleted.");

        $this->assertFalse(RedisCache::exists($key), "'{$key}' does exist.");
        $this->assertTrue(RedisCache::missing($key), "'{$key}' is not missing.");
    }

    /**
     * Execute assertions to confirm a multiple keys were deleted.
     *
     * @param  $deleted
     * @param  $keys
     */
    public function assertDeletedKeys($deleted, $keys): void
    {
        $this->assertIsArray($deleted);
        $this->assertIsArray($keys);

        foreach ($keys as $key) {
            $this->assertDeletedKey($deleted, $key);
        }
    }

    /**
     * Execute assertions to confirm the cache was flushed.
     *
     * @param  $array
     * @param  $output
     */
    public function assertFlushed($array, $output): void
    {
        $this->assertIsBool($output);
        $this->assertTrue($output);

        foreach ($array as $key => $value) {
            $this->assertTrue(RedisCache::missing($key), "'{$key}' is not missing.");
        }
    }
}
