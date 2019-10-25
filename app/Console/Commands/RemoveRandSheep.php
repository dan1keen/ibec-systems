<?php

namespace App\Console\Commands;

use App\Date;
use App\Jobs\RemoveRandSheepJob;
use App\Services\SheepService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

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
        $counter = 2; // При условии что Команда будет запускаться кроном каждые 5 минут
        do {
            $last = Date::whereRaw("description LIKE '%deleted%'")->orderBy("id", "desc")->first();
            $date = isset($last->date) ? $last->date : Date::all()->last()->date;
            $addDay = Carbon::parse($date)->addDays(10);
            RemoveRandSheepJob::dispatch($addDay);
            sleep(100);
        }while($counter-- > 0); // Иначе можно заменить $counter-- на while(true) тем самым цикл будет работать каждые 100 секунд
    }
}
