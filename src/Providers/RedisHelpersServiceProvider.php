<?php


namespace Sfneal\Helpers\Redis\Providers;


use Illuminate\Support\ServiceProvider;

class RedisHelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any RedisCache services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/redis-helpers.php' => base_path('config/redis-helpers.php'),
        ], 'config');
    }

    /**
     * Register any RedisCache services.
     *
     * @return void
     */
    public function register()
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/redis-helpers.php', 'redis-helpers');
    }
}
