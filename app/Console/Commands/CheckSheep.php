<?php

namespace App\Console\Commands;

use App\Jobs\CheckSheepJob;
use Illuminate\Console\Command;

class CheckSheep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sheep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks wether corral has 1 sheep';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $counter = 5;
        do {
            CheckSheepJob::dispatch();
            sleep(10);
        }while($counter-- > 0);

    }
}
