<?php

namespace Rawilk\LaravelUps\Commands;

use Illuminate\Console\Command;

class LaravelUpsCommand extends Command
{
    public $signature = 'laravel-ups';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
