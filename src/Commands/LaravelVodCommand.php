<?php

namespace Foxws\LaravelVod\Commands;

use Illuminate\Console\Command;

class LaravelVodCommand extends Command
{
    public $signature = 'laravel-vod';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
