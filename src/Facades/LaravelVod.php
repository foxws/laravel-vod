<?php

namespace Foxws\LaravelVod\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\LaravelVod\LaravelVod
 */
class LaravelVod extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Foxws\LaravelVod\LaravelVod::class;
    }
}
