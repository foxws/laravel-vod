<?php

namespace Foxws\Vod\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\LaravelVod\Vod
 */
class Vod extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Foxws\Vod\Vod::class;
    }
}
