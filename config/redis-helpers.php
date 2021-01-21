<?php

return [

    // Redis key prefix
    'prefix' => env('REDIS_KEY_PREFIX', 'app'),

    // Redis key ttl
    'ttl' => env('REDIS_KEY_EXPIRATION', 3600),

];
