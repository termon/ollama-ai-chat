<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Perf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:perf {size}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $list = [
            ["id" => 1, "name" => "Joe"],
            ["id" => 2, "name" => "Joe"],
            ["id" => 3, "name" => "Joe"],
            ["id" => 4, "name" => "Joe"],
        ];

        $size = $this->argument('size');

        $before = microtime(true);
        for ($i = 0; $i < $size; $i++) {
            serialize($list);
        }

        $after = microtime(true);
        $time = round(($after - $before), 2);

        $result = "Took {$time} sec/serialize";

        $this->info($result);
    }
}
