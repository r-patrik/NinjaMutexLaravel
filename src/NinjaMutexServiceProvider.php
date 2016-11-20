<?php

namespace PaddyHu\NinjaMutexLaravel;


use Illuminate\Support\ServiceProvider;
use NinjaMutex\Lock\LockInterface;
use NinjaMutex\Lock\MemcachedLock;
use NinjaMutex\MutexFabric;
use PaddyHu\NinjaMutexLaravel\Facade\NinjaMutex;

class NinjaMutexServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('ninja-mutex.php')]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'ninjaMutex');

        $this->app->singleton('NinjaMutex', function($app)
        {
            $config = $app['config']->get('ninjaMutex');

            $lockImplementor = $this->getLockImplementor($config);

            return new MutexFabric($config["driver"], $lockImplementor);
        });

        $this->app->alias("NinjaMutex", NinjaMutex::class);
    }

    /**
     * @param array $config
     * @return LockInterface
     * @throws InvalidLockImplementorException
     */
    private function getLockImplementor(array $config)
    {
        switch ($config["driver"]) {
            case "memcached":
                $memcached = new \Memcached();
                $memcached->addServers($config["storage"]["memcached"]["servers"]);
                $lockImplementor = new MemcachedLock($memcached);
                break;
        }

        if( ! isset($lockImplementor) ) {
            throw new InvalidLockImplementorException("Invalid lock implementor exception: " . $config["driver"]);
        }

        return $lockImplementor;
    }

    public function provides()
    {
        return ['ninjaMutex'];
    }
}