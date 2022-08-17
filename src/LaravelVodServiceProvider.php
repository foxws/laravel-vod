<?php

namespace Foxws\LaravelVod;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Foxws\LaravelVod\Commands\LaravelVodCommand;

class LaravelVodServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-vod')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-vod_table')
            ->hasCommand(LaravelVodCommand::class);
    }
}
