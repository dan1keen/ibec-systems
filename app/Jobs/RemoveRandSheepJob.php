<?php

namespace App\Jobs;

use App\Services\SheepService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveRandSheepJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($addDay)
    {
        $this->addDay = $addDay;
    }
    protected $addDay;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sheep_service = new SheepService;
        $sheep_service->removeSheep($this->addDay);
    }
}
