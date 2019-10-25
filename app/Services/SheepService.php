<?php


namespace App\Services;


use App\Models\Corral;
use App\Models\Sheep;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class SheepService
{


    public function generateRandSheeps(){
        $sheep = [];
        $corral = Corral::all();
        $date = Carbon::yesterday();
        for($i=0;$i<10;$i++) {
            $count = Sheep::all()->count();
            $random_corral = Corral::all()->random();

            if($count < 10) {
                $count = $count + 1;
                $sheep = Sheep::firstOrCreate(
                    [
                        "name" => "Sheep no." . $count,
                        "corral_id" => $random_corral->id,
                        "date" => $date->addDay()->format("Y-d-m")
                    ]


                );

            }
        }
        return $sheep;
    }

    public function createSheep(Carbon $date){
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
        $count = Sheep::all()->count();
        $count = $count + 1;

        $sheep = Sheep::firstOrCreate(
            [
                "name" => "Sheep no." . $count,
                "corral_id" => $corrals->random()->id,
                "date" => Sheep::select('date')->orderBy("id", "desc")->first()
            ]
        );
        return $sheep;
    }

    public function removeSheep(){
        $corrals = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
        $sheep = Sheep::findOrFail($corrals->random()->sheeps->random()->id)->delete();
        return $sheep;
    }

    public function checkSheep(){
        $corrals = Corral::has("sheeps", "=", 1)->with("sheeps")->get();

        $sheep = [];
        foreach ($corrals as $corral) {
            $corralsMore = Corral::has("sheeps", ">", 1)->with("sheeps")->get();
            $sheep = Sheep::where("corral_id", $corralsMore->random()->id)->first()->update(
                [
                    "corral_id" => $corral->id
                ]

            );

        }

        return $sheep;
    }
}