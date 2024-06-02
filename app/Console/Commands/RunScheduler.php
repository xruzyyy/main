<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunScheduler extends Command
{
    protected $signature = 'custom:scheduler';

    protected $description = 'Run the Laravel scheduler manually';

    public function handle()
    {
        $this->info('Running Laravel scheduler...');
        $exitCode = $this->call('schedule:run');
        $this->info('Laravel scheduler executed successfully.');
    }
}
