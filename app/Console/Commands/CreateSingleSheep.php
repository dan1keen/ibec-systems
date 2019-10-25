<?php

namespace App\Console\Commands;

use App\Date;
use App\Jobs\CreateSingleSheepJob;
use App\Models\Sheep;
use App\Services\SheepService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

class CreateSingleSheep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:sheep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a sheep every 10 seconds.';

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
            $last = Date::whereRaw("description LIKE '%created%'")->orderBy("id", "desc")->first();
            $date = $last->date;
            $addDay = Carbon::parse($date)->addDays();
            CreateSingleSheepJob::dispatch($counter, $addDay);
            sleep(10);
        }while($counter-- > 0);
    }
}
