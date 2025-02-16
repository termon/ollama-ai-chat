<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Initialise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise the application by clearing all caches and reseting storage link';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing application caches');
        $this->call('cache:clear', []);
        $this->call('view:clear', []);
        $this->call('route:clear', []);
        $this->call('queue:clear', []);
        $this->call('event:clear', []);
        $this->call('debugbar:clear', []);
        $this->call('config:clear', []);
        $this->call('auth:clear-resets', []);
        $this->call('optimize:clear', []);

        $this->info('Executing storage:link command with --force');
        $this->call('storage:unlink');
        $this->call('storage:link', ['--force' => true]);

        $this->info('Delete the storage/logs/laravel.log file');
    }
}
