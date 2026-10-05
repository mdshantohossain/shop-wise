<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset';

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
        passthru("php artisan config:clear");
        passthru("php artisan cache:clear");
        passthru("php artisan optimize:clear");

        passthru("php artisan optimize");
        passthru("php artisan config:cache");

        $this->info('application cache cleared successfully');
    }
}
