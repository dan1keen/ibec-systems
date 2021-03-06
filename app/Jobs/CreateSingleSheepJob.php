<?php

namespace App\Jobs;

use App\Services\SheepService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;

class CreateSingleSheepJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($counter,$addDay)
    {
        $this->counter = $counter;
        $this->addDay = $addDay;

    }
    protected $counter;
    protected $addDay;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "EXECUTING: " . $this->counter . "\n";
        $sheep_service = new SheepService;
        $sheep_service->createSheep($this->addDay);
    }
}
