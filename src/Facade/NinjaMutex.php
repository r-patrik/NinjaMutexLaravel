<?php


namespace PaddyHu\NinjaMutexLaravel\Facade;


use Illuminate\Support\Facades\Facade;

class NinjaMutex extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'NinjaMutex'; }
}