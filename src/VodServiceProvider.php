<?php

namespace Foxws\Vod;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VodServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-vod')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Vod::class, fn () => new Vod());
        $this->app->bind('vod', Vod::class);
    }
}
