<?php


namespace App\Services;


use App\Models\Corral;
use App\Models\Sheep;
use Spatie\Activitylog\Models\Activity;

class SheepService
{


    public function generateRandSheeps(){
        $sheep = [];
        for($i=0;$i<10;$i++) {
            $count = Sheep::all()->count();
            $random_corral = Corral::all()->random();

            if($count < 10) {
                $count = $count + 1;
                $sheep = Sheep::firstOrCreate(
                    [
                        "name" => "Sheep no." . $count,
                        "corral_id" => $random_corral->id
                    ]


                );
            }
        }
        return $sheep;


    }
}