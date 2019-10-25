<?php

namespace App\Console\Commands;

use App\Jobs\RemoveRandSheepJob;
use App\Services\SheepService;
use Illuminate\Console\Command;

class RemoveRandSheep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:sheep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes random sheep every 10th day';

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
            RemoveRandSheepJob::dispatch();
            sleep(100);
        }while($counter-- > 0);
    }
}
