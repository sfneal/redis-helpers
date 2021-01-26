<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Redis Key Expiration (TTL)
    |--------------------------------------------------------------------------
    |
    | Specify a default amount of time to live (in seconds) for items stored
    | using the RedisCache helper.  Setting a value of 0 will results in items
    | being stored indefinitely.
    |
    */
    'ttl' => env('REDIS_KEY_EXPIRATION', 3600),

];
