<?php

namespace App\Console\Commands;

use App\Date;
use App\Jobs\CheckSheepJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

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
        $counter = 5; // При условии что Команда будет запускаться кроном каждую минуту
        do {
            $last = Date::whereRaw("description LIKE '%updated%'")->orderBy("id", "desc")->first();
            $date = isset($last->date) ? $last->date : Date::all()->first()->date;
            $addDay = Carbon::parse($date)->addDays();
            CheckSheepJob::dispatch($addDay);
            sleep(10);
        }while($counter-- > 0); // Иначе можно заменить $counter-- на while(true) тем самым цикл будет работать каждые 10 секунд

    }
}
